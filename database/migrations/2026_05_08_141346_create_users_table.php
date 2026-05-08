<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('no_hp')->nullable();
            $table->string('password');
            $table->boolean('is_alumni')->default(false);
            $table->enum('status_pekerjaan', ['belum_bekerja', 'sedang_bekerja', 'wirausaha'])->nullable();
            $table->string('tempat_kerja')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
