<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validate = $request->validate([
                'login' => 'required|min:3|string',
                'email' => 'required|unique:users|email',
                'password' => 'required|min:5|string',
            ]);
        } catch (ValidationException $e) {
            dd($e->errors());
        }
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

    public function authentication(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $validate['email'])->first();

        $token = $user->createToken('auth_token');

        if(Hash::check($validate['password'], $user->password))
        {
            return response()->json([
                'token' => $token->plainTextToken,
                'message' => 'Аунтефикация прошла успешно',
            ]);
        }
    } 

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Выход выполнен'
        ]);
    }
}
