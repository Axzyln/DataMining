<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->vendorProfile;
        if (!$profile) {
            return redirect()->route('vendor.profile.edit')
                ->with('error', 'Please set up your vendor profile first.');
        }
        $products = $profile->products()->latest()->paginate(10);
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'category'       => 'required|string|max:100',
            'price'          => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit'           => 'required|string|max:20',
            'description'    => 'nullable|string',
        ]);

        $profile = auth()->user()->vendorProfile;
        $data['vendor_profile_id'] = $profile->id;
        Product::create($data);

        return redirect()->route('vendor.products.index')->with('success', 'Product added.');
    }

    public function edit(Product $product)
    {
        $this->authorizeOwner($product);
        return view('vendor.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeOwner($product);

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'category'       => 'required|string|max:100',
            'price'          => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit'           => 'required|string|max:20',
            'description'    => 'nullable|string',
            'is_available'   => 'sometimes|boolean',
        ]);

        $product->update($data);
        return redirect()->route('vendor.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeOwner($product);
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    private function authorizeOwner(Product $product): void
    {
        if ($product->vendorProfile->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function show(Product $product) { abort(404); }
}