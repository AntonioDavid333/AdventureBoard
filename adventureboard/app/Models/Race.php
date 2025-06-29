<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $guarded = [];

    public function heroes()
    {
        return $this->hasMany(Heroe::class);
    }
}
