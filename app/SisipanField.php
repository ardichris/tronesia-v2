<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SisipanField extends Model
{
    protected $guarded = [];

    public function kompetensi()
    {
        return $this->belongsTo(Kompetensi::class);
    }

    public function lingkupmateri()
    {
        return $this->belongsTo(LingkupMateri::class);
    }
}
