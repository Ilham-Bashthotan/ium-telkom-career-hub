<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PPDB;

class PPDBSeeder extends Seeder
{
    public function run(): void
    {
        PPDB::create([
            'judul' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2026/2027',
            'konten' => 'Daftarkan diri Anda di SMK Telkom sekarang juga! Dapatkan berbagai penawaran menarik dan beasiswa jalur prestasi.',
            'tanggal_mulai' => now()->subDays(1),
            'tanggal_selesai' => now()->addMonths(3),
            'admin_id' => 1,
        ]);
    }
}
