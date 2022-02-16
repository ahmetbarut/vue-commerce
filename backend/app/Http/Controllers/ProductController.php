<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $search =  '%'. str($request->input('search'))->trim() . '%';
            
            return ProductResource::collection(
                Product::where('name', 'like', $search)
                ->orWhere('description', 'like', $search)
                ->get()
            );
        }
        
        return ProductResource::collection(Product::paginate(15));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
