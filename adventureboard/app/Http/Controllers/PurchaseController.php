<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Weapon;
use App\Models\Heroe;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function destroy($purchaseId)
    {
        $purchase = Purchase::findOrFail($purchaseId);
        $weapon = $purchase->weapon;
        $user = Auth::user();
        if ($purchase) {
            $purchase->equipment()->delete();
            $price = $weapon->price;
            $user->coins += $price; // Reembolsar el precio de la arma
            $user->save();
            $purchase->delete();

            return back()->with('success', 'Arma eliminada del inventario.');
        }else {
             return back()->with('error', 'No tienes esta arma en tu inventario.');
        }

       
    }
}
