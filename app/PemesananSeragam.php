<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemesananSeragam extends Model
{
    protected $guarded = [];

    public function seragam()
    {
        return $this->belongsTo(Seragam::class, 'seragam_id', 'id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}
