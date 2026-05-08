<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogAktifitas;

class LogAktifitasSeeder extends Seeder
{
    public function run(): void
    {
        LogAktifitas::create([
            'admin_id' => 1,
            'aksi' => 'Membuat Data Awal',
            'detail' => 'Sistem telah diinisialisasi beserta penambahan data lowongan dan jurusan.',
        ]);
    }
}
