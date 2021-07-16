<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelasAnggota extends Model
{
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
