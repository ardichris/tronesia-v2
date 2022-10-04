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

    public function kompetensi()
    {
        return $this->belongsTo(Kompetensi::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelasanggota()
    {
        return $this->belongsTo(KelasAnggota::class);
    }
}
