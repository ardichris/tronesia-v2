<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo(User::class);
    }
}
