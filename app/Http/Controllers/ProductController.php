<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Retrieve all products
        return view('product.index', compact('products')); // Pass products to the view
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'photo' => 'nullable|image|max:1024',
            'title' => 'required|string|max:25',
            'price' => 'required|integer|',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos/products', $filename);
            $validatedData['photo'] = $filename; // Set the filename in the validated data
        }

        $product = Product::create($validatedData);
        
        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function add()
    {
        return view ('product.create');
    }
}
