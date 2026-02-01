<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
        ]);
        $token = $user->createToken('auth_token');

        return $token;
    }
}