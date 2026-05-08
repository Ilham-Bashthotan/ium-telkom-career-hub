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
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->id('perusahaan_id');
            $table->string('nama_perusahaan');
            $table->text('deskripsi')->nullable();
            $table->string('sektor_industri')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_mitra')->default(false);
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};
