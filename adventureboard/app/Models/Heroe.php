<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Heroe extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'name', 'background', 'image_uri', 'race_id', 'classrole_id', 'faction_id',
        'hp', 'defense', 'ki', 'strength', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function quests()
    {
        return $this->belongsToMany(Quest::class, 'submissions')
        ->withPivot(['status', 'accepted_at', 'description'])
        ->withTimestamps();
    }

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function classrole()
    {
        return $this->belongsTo(Classrole::class);
    }

    public function faction()
    {
        return $this->belongsTo(Faction::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'heroe_id');
    }
}
