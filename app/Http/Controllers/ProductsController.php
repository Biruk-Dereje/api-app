<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['inddex', 'show'])
        ];
    }
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

        $products = $request->user()->products()->create($fields);

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
        $products = products::find($id);
        $products->update($request->all());

        Gate::authorize('modify', $products);

        return $products;
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products, string $id)
    {
        $product = products::find($id);
        $product->delete();

        Gate::authorize('modify', $products);

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
