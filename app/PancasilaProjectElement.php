<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PancasilaProjectElement extends Model
{
    protected $guarded = [];

    public function element()
    {
        return $this->belongsTo(PancasilaElement::class, 'pe_id', 'id');
    }
}
