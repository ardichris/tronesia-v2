<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seragam extends Model
{
    protected $guarded = [];

    public function pemesanan()
    {
        return $this->hasMany(PemesananSeragam::class,'seragam_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
