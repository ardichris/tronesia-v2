<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiSiswa extends Model
{
    protected $guarded = [];
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
