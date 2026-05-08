<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktifitas extends Model
{
    protected $table = 'log_aktifitas';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'admin_id',
        'aksi',
        'detail',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
