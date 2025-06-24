<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Weapon;

class WeaponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Weapon::create([
    'name' => 'Iron Longsword',
    'image_uri' => 'https://picsum.photos/500/350',
    'description' => 'A well-balanced longsword forged from iron, suitable for most warriors.',
    'price' => 1500,
    'damage' => 25,
    'defense' => 5,
    ]);

    Weapon::create([
        'name' => 'Knight\'s Shield',
        'image_uri' => 'https://picsum.photos/500/350',
        'description' => 'A sturdy shield used by royal knights, offering excellent protection.',
        'price' => 2000,
        'damage' => 5,
        'defense' => 30,
    ]);

    Weapon::create([
        'name' => 'Elven Bow',
        'image_uri' => 'https://picsum.photos/500/350',
        'description' => 'A finely crafted bow made by elves, lightweight and deadly accurate.',
        'price' => 3000,
        'damage' => 35,
        'defense' => 3,
    ]);

    Weapon::create([
        'name' => 'Dwarven Axe',
        'image_uri' => 'https://picsum.photos/500/350',
        'description' => 'A heavy battle axe used by dwarves, capable of dealing massive damage.',
        'price' => 2500,
        'damage' => 40,
        'defense' => 8,
    ]);

    Weapon::create([
        'name' => 'Apprentice Staff',
        'image_uri' => 'https://picsum.photos/500/350',
        'description' => 'A simple wooden staff imbued with weak magical energy.',
        'price' => 800,
        'damage' => 15,
        'defense' => 10,
    ]);

    }
}
