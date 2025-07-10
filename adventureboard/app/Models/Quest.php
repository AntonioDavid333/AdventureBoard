<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $guarded = [];

    public function heroes()
    {
        return $this->belongsToMany(Heroe::class, 'heroe_quest', 'hero_id', 'quest_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
