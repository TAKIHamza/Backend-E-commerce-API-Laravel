<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categorys=Category::select('name')->get();
        return response()->json(['Products' =>$products,'Categorys'=>$categorys], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getProductsByCategory(Request $request,$category)
    {
         
    
        $products = Product::where('catigory', $category)->get();
    
        if ($products->isEmpty()) {
            return response()->json([
                'error' => 'No products found for the given category'
            ], 404);
        }
    
        return response()->json([
            'Products' => $products
        ], 200);
    }
    
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('product/image', $request->image, $imageName);
        
        $product = Product::create([
            'title' => $request->title,
            'image' => $imageName,
            'catigory' => $request->category,
            'description' => $request->description,
            'price' => $request->price ,
        ]);
        if (!$product) {
            return response()->json([
                'message' => $product,
            ], 404);
        }
        return response()->json([
            'message' => 'Item added successfully'
        ], 201);
    
      
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $productData = [
            'title' => $product->title,
            'price' => $product->price,
            'image' => $product->image,
            'category' => $product->category,
            'description' => $product->description,
        ];
        return response()->json($productData, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // This method is empty, you can add your custom logic here if needed.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $product->title = $request->input('title');
        $product->catigory = $request->input('catigory');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
    
        if ($request->hasFile('image')) {
            // Delete the existing image if it exists
            if ($product->image) {
                Storage::disk('public')->delete("product/image/{$product->image}");
            }
    
            $imageName = Str::random() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/product/image', $imageName);
            $product->image = $imageName;
        }
    
        $product->save();
    
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    function destroy(Request $request, $id)
{
    $user = Auth::user();
    //Check if the user making the request is an admin
    if ($user->role!="admin") {
        return response()->json(['message' => 'Access denied. Only admins can send users.'], 403);
    }

    // Find the product by ID
    $product = Product::find($id);

    // Check if the product exists
    if (!$product) {
        return response()->json(['message' => 'Product not found.'], 404);
    }
   
    // Delete the product
    if ($product->image) {
            $exist = Storage::disk('public')->exists("product/image/{$product->image}");
            if ($exist) {
                Storage::disk('public')->delete("product/image/{$product->image}");
            }
        }
    $product->delete();

    return response()->json(['message' => 'Product deleted successfully.'],200);
}
    
}
