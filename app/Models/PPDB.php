<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPDB extends Model
{
    protected $table = 'p_p_d_b_s';
    protected $primaryKey = 'ppdb_id';

    protected $fillable = [
        'judul',
        'konten',
        'banner_url',
        'tanggal_mulai',
        'tanggal_selesai',
        'admin_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
