<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

        return response()->json([
            'login' => $user->login,
            'redirect' => '/home'
        ], 201);
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validate['email'])->first();

        if(!$user)
        {
            return response()->json([
                'message' => 'Неверно введены данные',
                'error' => 'INVALID_CREDENTIALS',
            ], 401);
        }

        if(!Hash::check($validate['password'], $user->password))
        {
            return response()->json([
                'message' => 'Неверно введены данные',
                'error' => 'INVALID_CREDENTIALS',
            ], 401);
        }

        $token = $user->createToken('auth_token');
        return response()->json([
            'token' => $token->plainTextToken,
            'message' => 'Выполнен вход',
            'user' => [
                'id' => $user->id,
                'login' => $user->login,
                'email' => $user->email,
            ],
        ], 200);
    } 

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Выход выполнен'
        ]);
    }
}
