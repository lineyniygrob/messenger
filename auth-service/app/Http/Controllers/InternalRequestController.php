<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class InternalRequestController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'email' => $user->email
            ],
        ]);
    }
}
