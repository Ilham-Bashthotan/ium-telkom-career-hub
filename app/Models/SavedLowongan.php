<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedLowongan extends Model
{
    protected $fillable = ['user_id', 'lowongan_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'lowongan_id');
    }
}
