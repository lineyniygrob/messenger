<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\LoginService;
use App\Services\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function __construct(
        private RegisterService $registerService,
        private LoginService $loginService
    ){}   

    public function register(RegisterRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $token = $this->registerService->register($validate);

        return response()->json([
            "token" => $token->plainTextToken,
        ], Response::HTTP_CREATED);

    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $token = $this->loginService->login($credentials);

        return response()->json([
            'message' => 'авторизация успешна',
            'token' => $token,
        ], Response::HTTP_OK);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Вы вышли из аккаунта',
        ], Response::HTTP_OK);
    }

    public function test()
    {
        dd(Auth::check());
    }

}



