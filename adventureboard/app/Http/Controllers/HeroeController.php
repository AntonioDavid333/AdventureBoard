<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heroe;
use Inertia\Response;
use App\Models\Race;
use App\Models\Classrole;
use App\Models\Faction;
use App\Models\Equipment;
use App\Models\Purchase;
use App\Http\Requests\HeroRequest;


class HeroeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $purchases = $user ? $user->purchases()->with('weapon')->get() : collect();
        $purchasedWeapons = $user ? $user->purchasedWeapons : collect();
        $weapons = $user ? $user->weapons : collect();
        $heroes = $user->heroes()->with(['race', 'classrole', 'faction', 'equipments' => function ($query) {
            $query->with(['purchase.weapon']);
        },])->paginate(10);
         

        return inertia('Heroes/index', [
            'heroes' => $heroes,
            'purchasedWeapons' => $purchasedWeapons,
            'weapons' => $weapons,
            'purchases' => $purchases,
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
        $user = auth()->user();
        $heroe = Heroe::findOrFail($HeroId);
        $heroe->delete();
        $user->coins += 100; // Reembolsar las monedas al eliminar el héroe
        return redirect()->route('heroes.index')->with('success', 'Héroe eliminado correctamente.');
    }

    public function attach(Request $request)
    {
        $request->validate([
            'heroe_id' => 'required|exists:heroes,id',
            'purchase_id' => 'required|exists:purchases,id',
        ]);

         $exists = Equipment::where('heroe_id', $request->heroe_id)
                       ->where('purchase_id', $request->purchase_id)
                       ->exists();

        if ($exists) {
            return redirect()->route('heroes.index')->with('error', 'La arma ya está adjunta a este héroe.');
        }else {  
            Equipment::create([
                'heroe_id' => $request->heroe_id,
                'purchase_id' => $request->purchase_id,
                
            ]);

            return redirect()->route('heroes.index')/*->with('success', 'Arma adjuntado correctamente.')*/;
        }
    }
}
