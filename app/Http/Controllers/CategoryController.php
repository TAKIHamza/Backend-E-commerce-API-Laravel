<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
    //Check if the user making the request is an admin
    if ($user->role!="admin") {
        return response()->json(['message' => 'Access denied. Only admins can send users.'], 403);
    }

        
         Category::create([
            'name' => $request->name,
            
        ]);

        return response()->json([
            'message' => ' added ',
            
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($name)
    {

        $user = Auth::user();
    //Check if the user making the request is an admin
    if ($user->role!="admin") {
        return response()->json(['message' => 'Access denied. Only admins can send users.'], 403);
    }

        $category = Category::where('name', $name)->first();

        if ($category) {
            $products = Product::where('catigory', $name)->get();
    
            foreach ($products as $product) {
                // Delete the product's image from storage
                $exist = Storage::disk('public')->exists("product/image/{$product->image}");
            if ($exist) {
                Storage::disk('public')->delete("product/image/{$product->image}");
            }
                // Delete the product
                $product->delete();
            }
    
            // Delete the category
            $category->delete();
    
            // Category and related products successfully deleted
            return response()->json(['message' => 'Category and related products deleted'], 200);
        }
         else {
            // Category not found
            return response()->json(['message' => 'Category not found'], 404);
        }
    }
    
}
