<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cars;
use App\Models\Models;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cars = Cars::all();
        $models = []; // Initialize models as an empty array

        if ($request->has('car_id')) {
            $models = Model::where('car_id', $request->input('car_id'))->get();
        }

        $title = 'Create Product';
        return view ('product.create', compact('cars', 'models', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'model_id' => 'required|exists:models,id',
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
        
        return redirect()->route('products.create')->with('success', 'Product created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::findOrfail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $product = Product::findOrfail($id);
        // dd($products);
        $cars = Cars::all();
        $models = [];

        if ($request->has('car_id')) {
            $models = Model::where('car_id', $request->input('car_id'))->get();
        }
        $title = 'Update Product';
        return view ('product.create', compact('cars', 'models', 'title', 'product'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Product::findOrfail($id);
        $products->delete();
        return redirect()->route('all.view')->with('success', 'Product deleted successfully!');
    }

    public function view()
    {
        // $cars = Cars::all();
        $products = Product::with(['car', 'model'])->get();
        return view('product.products', compact('products'));
    }

    public function getModels($carId)
    {
        try {
            $models = Models::where('car_id', $carId)->get();
            return response()->json(['models' => $models]);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Error fetching models: ' . $e->getMessage());
    
            // Return a generic error response
            return response()->json(['error' => 'Unable to fetch models'], 500);
        }
    }
    
}
