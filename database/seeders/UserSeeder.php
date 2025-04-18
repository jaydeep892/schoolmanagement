<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@testmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $admin->assignRole($adminRole);

        // Create Teacher User
        $teacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@testmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $teacher->assignRole($teacherRole);
    }
}
