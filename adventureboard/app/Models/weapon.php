<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $guarded = [];

    public function equipments()
    {
        return $this->hasMany(Heroe::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

}
