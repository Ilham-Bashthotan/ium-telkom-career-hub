<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Alumni Pertama',
            'email' => 'alumni@gmail.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
            'is_alumni' => true,
            'status_pekerjaan' => 'belum_bekerja',
        ]);
        
        User::create([
            'nama_lengkap' => 'Pengguna Umum',
            'email' => 'umum@gmail.com',
            'password' => Hash::make('password123'),
            'no_hp' => '089876543210',
            'is_alumni' => false,
            'status_pekerjaan' => 'wirausaha',
        ]);
    }
}
