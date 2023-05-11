<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PancasilaProject extends Model
{
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pp_element()
    {
        return $this->hasMany(PancasilaProjectElement::class,'pp_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(PancasilaComment::class,'pp_id', 'id');
    }
}
