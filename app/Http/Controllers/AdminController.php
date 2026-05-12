<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VendorProfile;
use App\Models\Product;
use App\Models\Sale;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers     = User::count();
        $totalVendors   = User::where('role', 'vendor')->count();
        $totalBakers    = User::where('role', 'baker')->count();
        $totalProducts  = Product::count();
        $pendingVendors = VendorProfile::where('is_verified', false)->count();
        $totalSales     = Sale::sum('total');

        return view('admin.dashboard', compact(
            'totalUsers', 'totalVendors', 'totalBakers',
            'totalProducts', 'pendingVendors', 'totalSales'
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
        $users = User::orderBy('role')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) abort(403);
        $user->delete();
        return back()->with('success', 'User removed.');
    }
}