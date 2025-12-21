<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $viewer = Role::create(['name' => 'viewer']);
        $editor = Role::create(['name' => 'editor']);
        $admin = Role::create(['name' => 'admin']);

        $viewerUser = User::create([
            'name' => 'Viewer User',
            'username' => 'viewer',
            'email' => 'viewer@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $viewerUser->roles()->attach($viewer);

        $editorUser = User::create([
            'name' => 'Editor User',
            'username' => 'editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $editorUser->roles()->attach($editor);

        $adminUser = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $adminUser->roles()->attach($admin);
    }
}
