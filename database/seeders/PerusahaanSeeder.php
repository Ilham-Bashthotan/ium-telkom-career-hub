<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perusahaan;

class PerusahaanSeeder extends Seeder
{
    public function run(): void
    {
        Perusahaan::create([
            'nama_perusahaan' => 'PT Telkom Indonesia',
            'deskripsi' => 'Perusahaan Telekomunikasi Terbesar di Indonesia',
            'sektor_industri' => 'Telekomunikasi',
            'is_mitra' => true,
            'website' => 'https://telkom.co.id',
        ]);

        Perusahaan::create([
            'nama_perusahaan' => 'PT Gojek Tokopedia',
            'deskripsi' => 'Perusahaan teknologi yang melayani angkutan melalui jasa ojek.',
            'sektor_industri' => 'Teknologi',
            'is_mitra' => true,
            'website' => 'https://gotocompany.com',
        ]);
    }
}
