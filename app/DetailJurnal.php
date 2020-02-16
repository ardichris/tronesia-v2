<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailJurnal extends Model
{
    protected $guarded = [];

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
