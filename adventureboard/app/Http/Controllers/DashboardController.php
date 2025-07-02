<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        /*$user = auth()->user();
        $purchasedWeapons = $user ? $user->purchasedWeapons : collect();
        $weapons = $user ? $user->weapons : collect();
        $purchases = $user->purchases()->with('weapon')->get() ?? collect();*/

        return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        /*$purchasedWeapons = $user ? $user->purchasedWeapons : collect();*/
        $weapons = $user ? $user->weapons : collect();
        $purchases = $user->purchases()->with('weapon')->get() ?? collect();
        $heroes = $user->heroes()->with('equipments.purchase.weapon')->get();

        return Inertia::render('Dashboard/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            //'purchasedWeapons' => $purchasedWeapons,
            'weapons' => $weapons,
            'purchases' => $purchases,
            'heroes' => $heroes
        ]);
        }
}
