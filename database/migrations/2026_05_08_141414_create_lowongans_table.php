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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id('lowongan_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('link_apply')->nullable();
            $table->enum('sumber', ['manual', 'crawl'])->default('manual');
            $table->enum('status', ['draft', 'aktif', 'nonaktif'])->default('draft');
            $table->date('tanggal_posting')->nullable();
            $table->date('tanggal_expired')->nullable();
            $table->string('lokasi')->nullable();
            $table->enum('tipe_pekerjaan', ['Full-time', 'Part-time', 'Internship', 'Contract'])->nullable();
            $table->string('gaji')->nullable();
            $table->unsignedBigInteger('perusahaan_id')->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            
            $table->foreign('perusahaan_id')->references('perusahaan_id')->on('perusahaans')->onDelete('cascade');
            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusans')->onDelete('set null');
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
