<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heroe;
use Inertia\Response;
use App\Models\Race;
use App\Models\Classrole;
use App\Models\Faction;


class HeroeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $purchasedWeapons = $user ? $user->purchasedWeapons : collect();
        $weapons = $user ? $user->weapons : collect();
        $heroes = Heroe::paginate(10);
        return inertia('Heroes/index', [
            'heroes' => $heroes,
            'purchasedWeapons' => $purchasedWeapons,
            'weapons' => $weapons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $races = Race::all();
        $classroles = Classrole::all();
        $factions = Faction::all();
        return inertia('Heroes/Create', [
            'races' => $races,
            'classroles' => $classroles,
            'factions' => $factions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
