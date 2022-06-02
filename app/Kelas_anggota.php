<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas_anggota extends Model
{
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
