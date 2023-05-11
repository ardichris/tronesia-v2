<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PancasilaElement extends Model
{
    protected $guarded = [];

    public function score()
    {
        return $this->hasMany(PancasilaScore::class,'pe_id', 'id');
    }
}
