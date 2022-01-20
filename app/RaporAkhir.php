<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaporAkhir extends Model
{
    protected $guarded = [];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
