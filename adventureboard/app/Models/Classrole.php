<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classrole extends Model
{
    protected $guarded = [];

    public function heroes()
    {
        return $this->hasMany(Heroe::class);
    }
}
