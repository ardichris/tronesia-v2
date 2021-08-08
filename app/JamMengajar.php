<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JamMengajar extends Model
{
    protected $guarded = [];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class);
    }
}