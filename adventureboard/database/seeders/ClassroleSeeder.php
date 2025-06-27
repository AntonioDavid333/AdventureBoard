<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classrole;

class ClassroleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classrole::create([
            'classrole_name'=> 'Warrior',
            'bonus_at' => 50,
            'bonus_def' => 30,
            'bonus_ki' => 0,
            'bonus_hp' => 40
        ]);
        Classrole::create([
            'classrole_name'=> 'Paladin',
            'bonus_at' => 30,
            'bonus_def' => 40,
            'bonus_ki' => 10,
            'bonus_hp' => 35
        ]);
        Classrole::create([
            'classrole_name'=> 'Rogue',
            'bonus_at' => 40,
            'bonus_def' => 10,
            'bonus_ki' => 20,
            'bonus_hp' => 25
        ]);
        Classrole::create([
            'classrole_name'=> 'Druid',
            'bonus_at' => 10,
            'bonus_def' => 20,
            'bonus_ki' => 50,
            'bonus_hp' => 20
        ]);
        Classrole::create([
            'classrole_name'=> 'Monk',
            'bonus_at' => 20,
            'bonus_def' => 20,
            'bonus_ki' => 40,
            'bonus_hp' => 30
        ]);
        Classrole::create([
            'classrole_name'=> 'Archer',
            'bonus_at' => 45,
            'bonus_def' => 15,
            'bonus_ki' => 10,
            'bonus_hp' => 25
        ]);
        Classrole::create([
            'classrole_name'=> 'Explorer',
            'bonus_at' => 25,
            'bonus_def' => 25,
            'bonus_ki' => 10,
            'bonus_hp' => 30
        ]);
        Classrole::create([
            'classrole_name'=> 'Wizard',
            'bonus_at' => 0,
            'bonus_def' => 10,
            'bonus_ki' => 60,
            'bonus_hp' => 15
        ]);
        
    }
}
