<?php
namespace App\Services;

use App\Jobs\AddUserProfile;
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

        AddUserProfile::dispatch($user->id, $user->email, $data['display_name'] = null);
        return $token;
    }
}
