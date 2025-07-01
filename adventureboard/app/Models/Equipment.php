<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $guarded = [];
    //Es importante que tenga este protected porque si no, piensa que esta relacionado con la tabla equipment en minuscula
    protected $table = 'equipments';

    protected $fillable = ['heroe_id', 'purchase_id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function heroe()
    {
        return $this->belongsTo(Heroe::class);
    }
}

