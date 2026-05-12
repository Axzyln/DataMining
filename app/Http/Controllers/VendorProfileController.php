<?php
namespace App\Http\Controllers;

use App\Models\VendorProfile;
use App\Models\Product;
use Illuminate\Http\Request;

class VendorProfileController extends Controller
{
    public function dashboard()
    {
        $profile = auth()->user()->vendorProfile;
        $productCount = $profile ? $profile->products()->count() : 0;
        $lowStock = $profile ? $profile->products()->where('stock_quantity', '<', 10)->count() : 0;

        return view('vendor.dashboard', compact('profile', 'productCount', 'lowStock'));
    }

    public function edit()
    {
        $profile = auth()->user()->vendorProfile;
        return view('vendor.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'store_name'     => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'contact_number' => 'required|string|max:50',
            'description'    => 'nullable|string',
            'latitude'       => 'nullable|numeric',
            'longitude'      => 'nullable|numeric',
        ]);

        VendorProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        return back()->with('success', 'Profile updated. Awaiting admin verification.');
    }
}