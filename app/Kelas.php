<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'kelas_wali', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
