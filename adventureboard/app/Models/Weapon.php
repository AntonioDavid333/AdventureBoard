<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    //protected $guarded = [];

    protected $fillable = ['name', 'description','image_uri', 'price', 'damage', 'defense'];


    public function equipments()
    {
        return $this->hasMany(Heroe::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function heroes()
    {
        return $this->belongsToMany(Heroe::class, 'equipments');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'purchases');
    }

}
