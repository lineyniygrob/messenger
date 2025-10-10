<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'login' => $validated['login'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'messege' => 'register OK',
            'user' => [
                'id' => $user->id,
                'name' => $user->login,
                'email' => $user->email,
            ]
        ], 201);
    }
}
