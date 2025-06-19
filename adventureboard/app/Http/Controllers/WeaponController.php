<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weapon;

class WeaponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weapons = Weapon::all();
        return inertia ('Weapons/index', ['weapons'=> $weapons]);
    }
    /**
     * Buys the weapon and stores it into purchases if user has money enough.
     */
    public function buy()
    {
        $user = Auth::user();

        // Suponemos que el usuario tiene una propiedad "balance" o "money"
        if ($user->coins >= $weapon->price) {
            // Resta el precio al balance del usuario
            $user->coins -= $weapon->price;
            $user->save();

            // Guarda la compra
            Purchase::create([
                'user_id' => $user->id,
                'weapon_id' => $weapon->id,
            ]);

            return redirect()->back()->with('success', 'Compra realizada con éxito.');
        } else {
            return redirect()->back()->with('error', 'Dinero insuficiente para esta compra.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia ('Weapons/Create');
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
