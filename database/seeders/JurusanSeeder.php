<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = [
            ['kode_jurusan' => 'PPLG', 'nama_jurusan' => 'Pengembangan Perangkat Lunak dan Gim'],
            ['kode_jurusan' => 'TJKT', 'nama_jurusan' => 'Teknik Jaringan Komputer dan Telekomunikasi'],
            ['kode_jurusan' => 'DKV', 'nama_jurusan' => 'Desain Komunikasi Visual'],
            ['kode_jurusan' => 'ANM', 'nama_jurusan' => 'Animasi'],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::updateOrCreate(
                ['kode_jurusan' => $jurusan['kode_jurusan']],
                ['nama_jurusan' => $jurusan['nama_jurusan']]
            );
        }
    }
}
