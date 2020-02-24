<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
