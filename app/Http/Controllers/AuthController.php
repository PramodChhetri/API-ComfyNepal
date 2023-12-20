<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' =>  $user,
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        // Ensure the user is authenticated before attempting to log them out
        $user = Auth::user();

        if ($user) {
            // Revoke all tokens associated with the user
            $user->tokens()->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Logout',
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'User not authenticated',
        ]);
    }
}
