<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
                'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => bcrypt($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                        'access_token' => $token,
                            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request) {
        $authenticated = Auth::attempt($request->only('email', 'password'));

        if ($authenticated) {
            $user = $request->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credential'
        ], 422);
    }
}
