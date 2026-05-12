<?php
namespace App\Http\Controllers;

use App\Models\VendorProfile;
use App\Models\Product;

class VendorBrowseController extends Controller
{
    public function index()
    {
        $vendors = VendorProfile::with('user')
            ->where('is_verified', true)
            ->withCount('products')
            ->orderBy('store_name')
            ->paginate(12);

        return view('baker.vendors.index', compact('vendors'));
    }

    public function show(VendorProfile $vendor)
    {
        $vendor->load('user');

        $products = Product::where('vendor_profile_id', $vendor->id)
            ->where('is_available', true)
            ->where('stock_quantity', '>', 0)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('baker.vendors.show', compact('vendor', 'products'));
    }
}
