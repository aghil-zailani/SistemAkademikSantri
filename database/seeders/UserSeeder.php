<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@edusantri.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'status' => 'active',
        ]);

        // Create Teacher User
        User::create([
            'name' => 'Ahmad Hidayat',
            'email' => 'teacher@edusantri.com',
            'password' => Hash::make('teacher123'),
            'role' => 'teacher',
            'phone' => '081234567891',
            'status' => 'active',
        ]);

        // Create Staff User
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'staff@edusantri.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'phone' => '081234567892',
            'status' => 'active',
        ]);

        // Create Student User
        User::create([
            'name' => 'Muhammad Rizki',
            'email' => 'student@edusantri.com',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'phone' => '081234567893',
            'status' => 'active',
        ]);

        // Create more sample teachers
        User::create([
            'name' => 'Fatimah Zahra',
            'email' => 'fatimah@edusantri.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => '081234567894',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Abdullah Rahman',
            'email' => 'abdullah@edusantri.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => '081234567895',
            'status' => 'active',
        ]);

        // Create more sample staff
        User::create([
            'name' => 'Dewi Kartika',
            'email' => 'dewi@edusantri.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '081234567896',
            'status' => 'active',
        ]);

        // Create more sample students
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Siswa " . $i,
                'email' => "siswa{$i}@edusantri.com",
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '08123456789' . $i,
                'status' => 'active',
            ]);
        }
    }
}