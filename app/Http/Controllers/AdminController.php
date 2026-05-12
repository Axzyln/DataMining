<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recommendation;
use App\Models\Sale;
use App\Models\Setting;
use App\Models\User;
use App\Models\VendorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ── Headline stats ─────────────────────────────────────────────────
        $totalUsers     = User::count();
        $totalVendors   = User::where('role', 'vendor')->count();
        $totalBakers    = User::where('role', 'baker')->count();
        $totalProducts  = Product::count();
        $pendingVendors = VendorProfile::where('is_verified', false)->count();
        $totalRevenue   = Sale::sum('total');
        $activeUsers    = User::whereNotNull('last_login_at')
                              ->where('last_login_at', '>=', now()->subDays(7))
                              ->count();
        $newThisWeek    = User::where('created_at', '>=', now()->subDays(7))->count();

        // ── Sales trend – last 14 days ──────────────────────────────────────
        $trendRows = Sale::selectRaw('DATE(sale_date) as date, SUM(total) as revenue')
            ->where('sale_date', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $trendLabels   = [];
        $trendRevenues = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = now()->subDays($i);
            $trendLabels[]   = $d->format('M d');
            $trendRevenues[] = (float) ($trendRows->get($d->format('Y-m-d'))?->revenue ?? 0);
        }

        // ── Top 5 products by revenue ───────────────────────────────────────
        $topProducts = Sale::selectRaw('product_name, SUM(quantity_sold) as total_qty, SUM(total) as revenue')
            ->groupBy('product_name')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        // ── Products by category ────────────────────────────────────────────
        $byCategory = Product::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderByDesc('count')
            ->get();

        // ── Top 5 bakers by revenue ─────────────────────────────────────────
        $topBakers = Sale::selectRaw('user_id, SUM(total) as revenue, SUM(quantity_sold) as units')
            ->with('user:id,name')
            ->groupBy('user_id')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        // ── Recent logins ───────────────────────────────────────────────────
        $recentLogins = User::whereNotNull('last_login_at')
            ->orderByDesc('last_login_at')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalVendors', 'totalBakers', 'totalProducts',
            'pendingVendors', 'totalRevenue', 'activeUsers', 'newThisWeek',
            'trendLabels', 'trendRevenues',
            'topProducts', 'byCategory', 'topBakers', 'recentLogins'
        ));
    }

    public function vendors()
    {
        $vendors = VendorProfile::with('user')->paginate(15);
        return view('admin.vendors', compact('vendors'));
    }

    public function verifyVendor(VendorProfile $vendor)
    {
        $vendor->update(['is_verified' => true]);
        $vendor->user()->update(['is_verified' => true]);
        return back()->with('success', 'Vendor verified.');
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users-create');
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:admin,vendor,baker'],
        ]);

        $user = User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => $data['role'],
            'is_verified' => true,
        ]);

        if ($user->role === 'vendor') {
            VendorProfile::create([
                'user_id'     => $user->id,
                'store_name'  => $user->name,
                'is_verified' => false,
            ]);
        }

        return redirect()->route('admin.users')
            ->with('success', "User \"{$user->name}\" created successfully.");
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->isAdmin() && User::where('role', 'admin')->count() === 1) {
            return back()->with('error', 'Cannot change the role of the only admin.');
        }

        $data = $request->validate(['role' => ['required', 'in:admin,vendor,baker']]);

        $oldRole = $user->role;
        $user->update(['role' => $data['role']]);

        // Auto-create vendor profile if promoted to vendor
        if ($data['role'] === 'vendor' && !$user->vendorProfile) {
            VendorProfile::create([
                'user_id'     => $user->id,
                'store_name'  => $user->name,
                'is_verified' => false,
            ]);
        }

        return back()->with('success', "{$user->name}'s role updated from {$oldRole} to {$data['role']}.");
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) abort(403);
        $user->delete();
        return back()->with('success', 'User removed.');
    }

    // ── AI Recommendation Activity ─────────────────────────────────────────
    public function aiActivity()
    {
        $totalGenerated = Recommendation::count();
        $totalPositive  = Recommendation::where('feedback', 'up')->count();
        $totalNegative  = Recommendation::where('feedback', 'down')->count();

        $bakerStats = User::where('role', 'baker')
            ->withCount('recommendations')
            ->having('recommendations_count', '>', 0)
            ->orderByDesc('recommendations_count')
            ->get()
            ->map(function ($baker) {
                $baker->last_generated = Recommendation::where('user_id', $baker->id)
                    ->max('created_at');
                $baker->positive_feedback = Recommendation::where('user_id', $baker->id)
                    ->where('feedback', 'up')->count();
                $baker->negative_feedback = Recommendation::where('user_id', $baker->id)
                    ->where('feedback', 'down')->count();
                return $baker;
            });

        $recentRecs = Recommendation::with('user:id,name')
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        return view('admin.ai-activity', compact(
            'totalGenerated', 'totalPositive', 'totalNegative',
            'bakerStats', 'recentRecs'
        ));
    }

    // ── Operational Reports ────────────────────────────────────────────────
    public function reports()
    {
        $salesCount = Sale::count();
        $usersCount = User::count();
        $recsCount  = Recommendation::count();

        return view('admin.reports', compact('salesCount', 'usersCount', 'recsCount'));
    }

    public function exportSalesCsv()
    {
        $filename = 'sales_report_' . now()->format('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $sales = Sale::with('user:id,name,email')->orderByDesc('sale_date')->get();

        $callback = function () use ($sales) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Baker Name', 'Baker Email', 'Product', 'Qty Sold', 'Unit Price', 'Total', 'Sale Date']);
            foreach ($sales as $s) {
                fputcsv($out, [
                    $s->id,
                    $s->user?->name ?? '-',
                    $s->user?->email ?? '-',
                    $s->product_name,
                    $s->quantity_sold,
                    $s->unit_price,
                    $s->total,
                    $s->sale_date,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportUsersCsv()
    {
        $filename = 'users_report_' . now()->format('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $users = User::orderBy('role')->orderBy('name')->get();

        $callback = function () use ($users) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Name', 'Email', 'Role', 'Verified', 'Registered', 'Last Login']);
            foreach ($users as $u) {
                fputcsv($out, [
                    $u->id,
                    $u->name,
                    $u->email,
                    $u->role,
                    $u->is_verified ? 'Yes' : 'No',
                    $u->created_at->format('Y-m-d'),
                    $u->last_login_at?->format('Y-m-d H:i') ?? 'Never',
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportRecommendationsCsv()
    {
        $filename = 'recommendations_report_' . now()->format('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $recs = Recommendation::with('user:id,name,email')->orderByDesc('created_at')->get();

        $callback = function () use ($recs) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Baker Name', 'Baker Email', 'Product', 'Score', 'Feedback', 'Generated At']);
            foreach ($recs as $r) {
                fputcsv($out, [
                    $r->id,
                    $r->user?->name ?? '-',
                    $r->user?->email ?? '-',
                    $r->product_name,
                    $r->score,
                    $r->feedback ?? 'none',
                    $r->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── System Settings ────────────────────────────────────────────────────
    public function settings()
    {
        $settings = [
            'app_name'                  => Setting::get('app_name', config('app.name')),
            'allow_baker_registration'  => Setting::get('allow_baker_registration', '1'),
            'allow_vendor_registration' => Setting::get('allow_vendor_registration', '1'),
            'ai_max_recommendations'    => Setting::get('ai_max_recommendations', '8'),
            'maintenance_mode'          => Setting::get('maintenance_mode', '0'),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        $data = $request->validate([
            'app_name'                  => ['required', 'string', 'max:100'],
            'allow_baker_registration'  => ['boolean'],
            'allow_vendor_registration' => ['boolean'],
            'ai_max_recommendations'    => ['required', 'integer', 'min:1', 'max:20'],
            'maintenance_mode'          => ['boolean'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, (string) $value);
        }

        // Checkboxes are not sent when unchecked
        foreach (['allow_baker_registration', 'allow_vendor_registration', 'maintenance_mode'] as $toggle) {
            if (!$request->has($toggle)) {
                Setting::set($toggle, '0');
            }
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
