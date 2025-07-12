<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $guarded = [];

    public function heroes()
    {
        return $this->belongsToMany(Heroe::class, 'submissions')
        ->withPivot(['status', 'accepted_at', 'description'])
        ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(\App\Models\Submission::class);
    }
}
