<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LingkupMateri extends Model
{
    protected $guarded = [];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id');
    }
}
