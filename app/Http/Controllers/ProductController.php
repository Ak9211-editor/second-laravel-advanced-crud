<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::orderBy('id', 'desc')->paginate(10); // Add pagination here
    return view('products.index', compact('products')); // ✅ Pass it to the view
}



    public function create()
    {
        $products = Product::all(); // or any data you need
    return view('products.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'sku'   => 'required|unique:products',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $filename);
        }

        Product::create([
            'name'   => $request->name,
            'sku'    => $request->sku,
            'price'  => $request->price,
            'image'  => $filename,
            'status' => 1,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required',
            'sku'   => 'required|unique:products,sku,' . $product->id,
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('uploads/' . $product->image))) {
                File::delete(public_path('uploads/' . $product->image));
            }

            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $filename);
            $product->image = $filename;
        }

        $product->update([
            'name'   => $request->name,
            'sku'    => $request->sku,
            'price'  => $request->price,
            'image'  => $product->image,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image && File::exists(public_path('uploads/' . $product->image))) {
            File::delete(public_path('uploads/' . $product->image));
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    
 public function toggleStatus(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Make sure you're getting numeric value
    $product->status = $request->status == 1 ? 1 : 0;
    $product->save();

    return response()->json(['success' => true, 'message' => 'Status updated']);
}


}
