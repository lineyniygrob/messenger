<?php
namespace App\Services;

use App\Models\UserProfile;

class UserProfileService
{
    public function create(array $data)
    {
        if(!$data['name']){
            $data['name'] = $data['email'];
        }
        UserProfile::create([
            'auth_user_id' => $data['id'],
            'display_name' => $data['name']
        ])->firstOrFail();
    }
}
