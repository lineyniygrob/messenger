<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'администратор']);
        $userRole = Role::firstOrCreate(['name' => 'user'], ['description' => 'пользователь']);

        $permissions = [
            ['name' => 'user.create', 'description' => 'Создание пользователей'],
            ['name' => 'user.edit', 'description' => 'Редактирование пользователей'],
            ['name' => 'user.delete', 'description' => 'Удаление пользователей'],
            ['name' => 'user.assign_role', 'description' => 'Назначение ролей'],
            ['name' => 'post.create', 'description' => 'Создание постов'],
            ['name' => 'post.edit', 'description' => 'Редактирование постов'],
            ['name' => 'post.delete', 'description' => 'Удаление постов'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], ['description' => $perm['description']]);
        }

        $adminRole->permissions()->attach(Permission::all());
        $userRole->permissions()->attach(Permission::whereIn('name', [
            'user.edit',
            'post.create',
            'post.edit',
            'post.delete',
        ])->get());
    }
}
