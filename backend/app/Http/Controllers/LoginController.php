<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        if($validator->failed()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Login successful',
                'user' => auth()->user()->createToken('token')->plainTextToken
            ], 200);
        }

        return response()->json([
            'message' => 'Login failed'
        ], 401);
    }

    public function register(Request $request)
    {
        # code...
    }
    
}
