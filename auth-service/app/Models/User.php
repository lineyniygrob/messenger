<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'login',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function hasAnyRole($roles)
    {
        return $this->role()->whereIn('name',$roles)->exists();
    }

    public function hasAnyPermission($permissions)
    {
        return $this->role()->whereHas('permissions', function($query) use ($permissions){
            return $query->whereIn('name', $permissions);
        })->exists();
    }

    public function getAllPermissions()
    {
        return $this->role()->with('Permissions')->get()->toArray();
    }
}

