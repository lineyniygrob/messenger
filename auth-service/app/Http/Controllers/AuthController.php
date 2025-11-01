<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token, $user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Неверно введены данные',
                'error' => 'INVALID_CREDENTIALS',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token, Auth::guard('api')->user());
    } 

    public function logout(Request $request)
    {
        try {
            Auth::guard('api')->logout();
        } catch (JWTException $exception) {
            return response()->json([
                'message' => 'Не удалось завершить сессию',
                'error' => 'LOGOUT_FAILED',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Выход выполнен',
        ]);
    }

    public function refresh()
    {
        $user = Auth::guard('api')->user();
        $newToken = Auth::guard('api')->refresh();

        return $this->respondWithToken($newToken, $user);
    }

    protected function respondWithToken(string $token, ?User $user = null, int $status = Response::HTTP_OK)
    {
        $user ??= Auth::guard('api')->setToken($token)->user();

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'login' => $user->login,
                'email' => $user->email,
            ],
        ], $status);
    }
}
