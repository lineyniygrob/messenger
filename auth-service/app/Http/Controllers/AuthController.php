<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validate = $request->validated();

        $user = User::create([
            'login' => $validate['login'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);

        $token = $user->createToken('auth_token');

        return response()->json([
            "token" => $token->plainTextToken,
        ], 200);

    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Вы вышли из аккаунта',
        ], 200);
    }

}


