<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $guarded = [];

    public function listbarang()
    {
        return $this->hasMany(ListBarangMasuk::class,'barangmasuk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
