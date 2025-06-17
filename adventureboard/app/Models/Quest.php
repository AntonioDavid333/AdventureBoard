<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $guarded = [];

    public function heroes()
    {
        return $this->belongsToMany(Heroe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
