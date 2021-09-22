<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswas extends Model
{
    protected $guarded = [];

    public function kelasanggota()
    {
        return $this->belongsTo(KelasAnggota::class);
    }
}
