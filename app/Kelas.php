<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'kelas_wali', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function anggota()
    {
        return $this->hasMany(KelasAnggota::class);
    }
}
