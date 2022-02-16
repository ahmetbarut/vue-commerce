<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->orders);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cardname' => 'required|string',
            'cardnumber' => 'required|numeric|digits:16',
            'cardexpiry' => 'required|max:5',
            'cardcvv' => 'required|numeric|digits:3',
            'carts' => 'required|array',
            'carts.*.id' => 'required|numeric',
            'carts.*.quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $products = $request->collect('carts');
        $amount = $products->sum(function ($product) {
            return Product::find($product['id'])->price * $product['quantity'];
        });

        // payment

        $order = Order::create([
            'order_number' => uniqid(),
            'user_id' => $request->user()->id,
            'amount' => $amount,
            'payment_method' => 'card',
            'status' => 'pending',
        ]);

        // mail

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ]);
        
    }
}
