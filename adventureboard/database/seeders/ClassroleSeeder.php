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
            'classrole_name'=> 'Warrior'
        ]);
        Classrole::create([
            'classrole_name'=> 'Paladin'
        ]);
        Classrole::create([
            'classrole_name'=> 'Rogue'
        ]);
        Classrole::create([
            'classrole_name'=> 'Druid'
        ]);
        Classrole::create([
            'classrole_name'=> 'Monk'
        ]);
        Classrole::create([
            'classrole_name'=> 'Archer'
        ]);
        Classrole::create([
            'classrole_name'=> 'Explorer'
        ]);
        Classrole::create([
            'classrole_name'=> 'Wizard'
        ]);
        
    }
}
