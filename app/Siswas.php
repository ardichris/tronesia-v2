<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswas extends Model
{
    protected $guarded = [];

    public function kelasanggota()
    {
        return $this->belongsTo(KelasAnggota::class, 'id', 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
