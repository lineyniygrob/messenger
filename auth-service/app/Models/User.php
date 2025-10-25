<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use function PHPUnit\Framework\returnArgument;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'login',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

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

