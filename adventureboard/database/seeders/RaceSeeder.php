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
            'race_name'=>'Human'
        ]);
        Race::create([
            'race_name'=>'Elf'
        ]);
        Race::create([
            'race_name'=>'Orc'
        ]);
        Race::create([
            'race_name'=>'Dwarf'
        ]);
        Race::create([
            'race_name'=>'Halfling'
        ]);
    }
}
