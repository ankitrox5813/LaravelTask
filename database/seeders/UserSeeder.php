<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $user = Role::firstOrCreate(['name' => 'user']);
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $panelUser = Role::firstOrCreate(['name' => 'panel_user']);

        // Admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@testmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $adminUser->syncRoles(['admin', 'super_admin', 'panel_user']);

        // 5 dummy users
        User::factory(5)->create()->each(function ($u) {
            $u->syncRoles(['user', 'panel_user']);
        });
    }
}