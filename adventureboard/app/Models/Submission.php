<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
     protected $fillable = [
        'heroe_id',
        'quest_id',
        'status',
        'accepted_at',
        'description'
    ];

    public function heroe()
    {
        return $this->belongsTo(Heroe::class);
    }

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }
}
