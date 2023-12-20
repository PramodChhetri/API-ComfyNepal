<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);

        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json([
            'status' => 1,
            'message' => "Product of id " . $id . " updated successfully.",
        ]);
    }

    /**
     * search for name
     */
    public function search(string $name)
    {
        $products = Product::where('name', 'like', '%' . $name . '%')->get();
        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $products
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return response()->json([
            "status" => 1,
            "message" => "Product of id " . $id . " deleted successfully."
        ]);
    }
}
