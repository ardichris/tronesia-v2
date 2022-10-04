<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KitirSiswa extends Model
{
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function approve()
    {
        return $this->belongsTo(User::class, 'approve_by', 'id');
    }
}
