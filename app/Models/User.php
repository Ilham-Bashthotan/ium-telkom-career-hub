<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_hp',
        'password',
        'is_alumni',
        'status_pekerjaan',
        'tempat_kerja',
    ];

    protected $hidden = [
        'password',
    ];
}
