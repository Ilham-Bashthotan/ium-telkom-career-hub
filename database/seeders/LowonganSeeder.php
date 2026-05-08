<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lowongan;

class LowonganSeeder extends Seeder
{
    public function run(): void
    {
        Lowongan::create([
            'judul' => 'Software Engineer',
            'deskripsi' => 'Kami mencari Software Engineer berpengalaman untuk bergabung dengan tim.',
            'link_apply' => 'https://telkom.co.id/career',
            'sumber' => 'manual',
            'status' => 'aktif',
            'tanggal_posting' => now(),
            'tanggal_expired' => now()->addDays(30),
            'lokasi' => 'Bandung',
            'tipe_pekerjaan' => 'Full-time',
            'gaji' => 'Rp 7.000.000 - Rp 10.000.000',
            'perusahaan_id' => 1,
            'jurusan_id' => 1, // PPLG
            'admin_id' => 1,
        ]);

        Lowongan::create([
            'judul' => 'Network Administrator',
            'deskripsi' => 'Membutuhkan lulusan TJKT untuk mengelola jaringan lokal perusahaan.',
            'link_apply' => 'https://telkom.co.id/career',
            'sumber' => 'manual',
            'status' => 'aktif',
            'tanggal_posting' => now(),
            'tanggal_expired' => now()->addDays(14),
            'lokasi' => 'Jakarta',
            'tipe_pekerjaan' => 'Full-time',
            'gaji' => 'Rp 6.000.000 - Rp 8.000.000',
            'perusahaan_id' => 1,
            'jurusan_id' => 2, // TJKT
            'admin_id' => 1,
        ]);
    }
}
