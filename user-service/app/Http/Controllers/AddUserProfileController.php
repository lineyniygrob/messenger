<?php

namespace App\Http\Controllers;

use App\Services\UserProfileService;
use Illuminate\Http\Request;

class AddUserProfileController extends Controller
{
    public function __construct(
        public UserProfileService $profile
    ) {
    }
    public function __invoke(Request $request)
    {
        $credentials = [
            'id' => $request->header('X-Id-User'),
            'email' => $request->header('X-Email-User'),
            'name' => $request->header('X-Name-User')
        ];
        $this->profile->create($credentials);
        return response()->json(['massege' => 'profile created']);
    }
}
