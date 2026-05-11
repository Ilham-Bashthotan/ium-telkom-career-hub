<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $table = 'lowongans';
    protected $primaryKey = 'lowongan_id';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($lowongan) {
            // Automatically set status to nonaktif only if deadline has passed the entire day
            if ($lowongan->tanggal_expired && $lowongan->tanggal_expired->endOfDay()->isPast()) {
                $lowongan->status = 'nonaktif';
            }
        });
    }

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

    protected $casts = [
        'tanggal_posting' => 'datetime',
        'tanggal_expired' => 'datetime',
    ];

    public function getIsExpiredAttribute()
    {
        return $this->tanggal_expired && $this->tanggal_expired->isPast();
    }

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
