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
    'image_uri' => 'Weapons_images/IronLongsword.jpg',
    'description' => 'A well-balanced longsword forged from iron, suitable for most warriors.',
    'price' => 1500,
    'damage' => 25,
    'defense' => 5,
    ]);

    Weapon::create([
        'name' => 'Knight\'s Shield',
        'image_uri' => 'Weapons_images/KnightsShield.jpg',
        'description' => 'A sturdy shield used by royal knights, offering excellent protection.',
        'price' => 2000,
        'damage' => 5,
        'defense' => 30,
    ]);

    Weapon::create([
        'name' => 'Elven Bow',
        'image_uri' => 'Weapons_images/ElvenBow.jpg',
        'description' => 'A finely crafted bow made by elves, lightweight and deadly accurate.',
        'price' => 3000,
        'damage' => 35,
        'defense' => 3,
    ]);

    Weapon::create([
        'name' => 'Dwarven Axe',
        'image_uri' => 'Weapons_images/DwarvenAxe.jpg',
        'description' => 'A heavy battle axe used by dwarves, capable of dealing massive damage.',
        'price' => 2500,
        'damage' => 40,
        'defense' => 8,
    ]);

    Weapon::create([
        'name' => 'Apprentice Staff',
        'image_uri' => 'Weapons_images/ApprenticeStaff.jpg',
        'description' => 'A simple wooden staff imbued with weak magical energy.',
        'price' => 800,
        'damage' => 15,
        'defense' => 10,
    ]);

    Weapon::create([
        'name' => 'Dagger',
        'image_uri' => 'Weapons_images/Dagger.jpg',
        'description' => 'Simple and versatile daga',
        'price' => 20,
        'damage' => 30,
        'defense' => 10,
    ]);

    Weapon::create([
        'name' => 'Test Create Weapon 01',
        'image_uri' => 'Weapons_images/default.jpg',
        'description' => 'test for weapon shopping',
        'price' => 10,
        'damage' => 20,
        'defense' => 20,
    ]);

    }
}
