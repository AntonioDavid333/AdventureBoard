<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weapon;
use App\Http\Requests\WeaponRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Heroe;

class WeaponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $weapons = Weapon::all();
        $purchasedWeapons = $user->purchasedWeapons;
        return inertia ('Weapons/index', ['weapons'=> $weapons, 'purchasedWeapons' => $purchasedWeapons, 'auth' => [
            'user' => $user,
            'roles' => $user->getRoleNames(),
        ],]);
    }
    /**
     * Buys the weapon and stores it into purchases if user has money enough.
     */
    public function buy($weaponId)
    {
        $weapon = Weapon::findOrFail($weaponId);
        $user = Auth::user();

        if ($user->purchasedWeapons()->where('weapon_id', $weaponId)->exists()) {
            return back()->with('error', 'Ya tienes esta arma.');
        }

        if ($user->coins >= $weapon->price) {
            $user->coins -= $weapon->price;
            $user->save();

            Purchase::create([
                'user_id' => $user->id,
                'weapon_id' => $weapon->id,
            ]);

            // Recarga los datos y devuelve la vista actualizada
            return redirect()->back()->with('success', 'Compra realizada con éxito.');
        } else {
            return back()->with('error', 'Dinero insuficiente para esta compra.');
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
     * /
     * @param App\Http\Requests\WeaponRequest
     * @return \Illuminate\Http\Response
     */
    public function store(WeaponRequest $request)
    {
        Weapon::create($request->validated());
        return redirect()->route('weapons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $weapon = Weapon::findOrFail($id);
        return inertia('Weapons/Edit', ['weapon' => $weapon]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param App\Http\Requests\WeaponRequest
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(WeaponRequest $request, $id)
    {
        $weapon = Weapon::findOrFail($id);
        $weapon->update($request->validated());
        return redirect()->route('weapons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($weaponId)
    {
        $weapon = Weapon::findOrFail($weaponId);

        $purchases = $weapon->purchases()->with('user')->get();

        foreach ($purchases as $purchase) {
            $user = $purchase->user;
            if ($user) {
                $user->coins += $weapon->price;
                $user->save();
            }
        }
        
        $weapon->delete();
        return redirect()->route('weapons.index')->with('success', 'Arma eliminada correctamente.');
    }
}
