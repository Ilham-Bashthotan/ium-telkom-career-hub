<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            JurusanSeeder::class,
            PerusahaanSeeder::class,
            LowonganSeeder::class,
            PPDBSeeder::class,
            LogAktifitasSeeder::class,
        ]);
    }
}
