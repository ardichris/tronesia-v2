<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KurmerReport extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function detail()
    {
        return $this->hasMany(KmrDetail::class,'kmr_id', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function hrteacher()
    {
        return $this->belongsTo(User::class, 'hrteacher_id', 'id');
    }
}
