<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Race;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Race::create([
            'race_name'=>'Human',
            'bonus_at' => 20,
            'bonus_def' => 20,
            'bonus_ki' => 20,
            'bonus_hp' => 25
        ]);
        Race::create([
            'race_name'=>'Elf',
            'bonus_at' => 10,
            'bonus_def' => 10,
            'bonus_ki' => 50,
            'bonus_hp' => 20
        ]);
        Race::create([
            'race_name'=>'Orc',
            'bonus_at' => 50,
            'bonus_def' => 20,
            'bonus_ki' => 0,
            'bonus_hp' => 40
        ]);
        Race::create([
            'race_name'=>'Dwarf',
            'bonus_at' => 15,
            'bonus_def' => 45,
            'bonus_ki' => 0,
            'bonus_hp' => 35
        ]);
        Race::create([
            'race_name'=>'Halfling',
            'bonus_at' => 25,
            'bonus_def' => 25,
            'bonus_ki' => 10,
            'bonus_hp' => 30
        ]);
    }
}
