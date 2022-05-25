<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaporPetra extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
