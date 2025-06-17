<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];

    public function weapons()
    {
        return $this->belongsTo(Weapon::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class);
    }

}
