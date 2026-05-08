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
        Schema::create('p_p_d_b_s', function (Blueprint $table) {
            $table->id('ppdb_id');
            $table->string('judul');
            $table->text('konten');
            $table->string('banner_url')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_p_d_b_s');
    }
};
