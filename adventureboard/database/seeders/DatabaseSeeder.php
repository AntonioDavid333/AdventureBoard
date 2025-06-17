<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\classrole;
use App\Models\race;
use App\Models\weapon;
use App\Models\faction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(FactionSeeder::class);
        $this->call(ClassroleSeeder::class);
        $this->call(RaceSeeder::class);
        $this->call(WeaponSeeder::class);
    }
}
