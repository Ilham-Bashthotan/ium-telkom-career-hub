<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusans';
    protected $primaryKey = 'jurusan_id';

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
    ];

    public function lowongans()
    {
        return $this->hasMany(Lowongan::class, 'jurusan_id', 'jurusan_id');
    }
}
