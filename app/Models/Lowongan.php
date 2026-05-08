<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $table = 'lowongans';
    protected $primaryKey = 'lowongan_id';

    protected $fillable = [
        'judul',
        'deskripsi',
        'link_apply',
        'sumber',
        'status',
        'tanggal_posting',
        'tanggal_expired',
        'lokasi',
        'tipe_pekerjaan',
        'gaji',
        'perusahaan_id',
        'jurusan_id',
        'admin_id',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id', 'perusahaan_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'jurusan_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
