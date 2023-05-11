<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PancasilaReport extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }



}
