<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heroe;
use Inertia\Response;
use App\Models\Race;
use App\Models\Classrole;
use App\Models\Faction;
use App\Http\Requests\HeroRequest;


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
        $heroes = $user->heroes()->paginate(10); 

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
        $user = auth()->user();
        $classroles = Classrole::all();
        $factions = Faction::all();

        if ($user->coins >= 100) {
            return inertia('Heroes/Create', [
                'races' => $races,
                'classroles' => $classroles,
                'factions' => $factions
            ]);
        } else {
            return redirect()->route('heroes.index')->with('error', 'No tienes suficientes monedas para crear un héroe.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeroRequest $request)
    {
        $user = auth()->user();
        if ($user->coins < 100) {
            return redirect()->route('heroes.index')->with('error', 'No tienes suficientes monedas para crear un héroe.');
        }

        $data = $request->validated();
        $data['user_id'] = $user->id;

        if ($request->hasFile('image_uri')) {
            $file = $request->file('image_uri');
            $path = $file->store('Heroes_images', 'public');
            $data['image_uri'] = $path;
        } else {
            $data['image_uri'] = 'Heroes_images/default.jpg';
        }

        // Ahora sí, descuenta las monedas al crear el héroe
        $user->coins -= 100;
        $user->save();

        Heroe::create($data);

        return redirect()->route('heroes.index');
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
    public function destroy($HeroId)
    {
        $heroe = Heroe::findOrFail($HeroId);
        $heroe->delete();
        return redirect()->route('heroes.index')->with('success', 'Héroe eliminado correctamente.');
    }
}
