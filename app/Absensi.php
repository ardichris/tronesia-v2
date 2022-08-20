<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function approve()
    {
        return $this->belongsTo(User::class, 'approve_by', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
