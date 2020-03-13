<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KitirSiswa extends Model
{
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
