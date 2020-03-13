<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporSarpras extends Model
{
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updater_id', 'id');
    }
}
