<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListBarangMasuk extends Model
{
    protected $guarded = [];

    public function barangmasuk()
    {
        return $this->belongsTo(BarangMasuk::class, 'barangmasuk_id', 'id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
