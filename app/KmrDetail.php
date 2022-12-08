<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KmrDetail extends Model
{
    protected $guarded = [];

    public function kurmerreport()
    {
        return $this->belongsTo(KurmerReport::class);
    }
}
