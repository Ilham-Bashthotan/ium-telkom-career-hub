<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaans';
    protected $primaryKey = 'perusahaan_id';

    protected $fillable = [
        'nama_perusahaan',
        'deskripsi',
        'sektor_industri',
        'logo',
        'is_mitra',
        'website',
    ];

    public function lowongans()
    {
        return $this->hasMany(Lowongan::class, 'perusahaan_id', 'perusahaan_id');
    }
}
