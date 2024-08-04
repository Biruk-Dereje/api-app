<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Products::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $products = Products::create($fields);

        return $products;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the product by ID or fail with a 404 error
        $product = Products::findOrFail($id);

        // Return the product data as a JSON response
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, string $id)
    {
        $product = products::find($id);
        $product->update($request->all());

        return $product;
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products, string $id)
    {
        $product = products::find($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
