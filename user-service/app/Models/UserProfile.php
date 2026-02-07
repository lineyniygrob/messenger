<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'auth_user_id',
        'display_name',
        'description_profile',
        'avatar_url'
    ];
}
