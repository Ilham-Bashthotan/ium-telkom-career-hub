<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function lowongans()
    {
        return $this->hasMany(Lowongan::class, 'admin_id', 'admin_id');
    }

    public function ppdbs()
    {
        return $this->hasMany(PPDB::class, 'admin_id', 'admin_id');
    }

    public function logAktifitas()
    {
        return $this->hasMany(LogAktifitas::class, 'admin_id', 'admin_id');
    }
}
