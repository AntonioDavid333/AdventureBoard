<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Quest;

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

        $quests = Quest::with('user')->orderBy('created_at', 'desc')->get();
        $createdQuests = $user->quests()->with('user')->latest()->get();
        $heroIds = $user->heroes()->pluck('id');
        $joinedQuests = Quest::whereHas('heroes', function ($query) use ($heroIds) {
        $query->whereIn('heroes.id', $heroIds);
        })->with('user')->latest()->get();


        return Inertia::render('Dashboard/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            //'purchasedWeapons' => $purchasedWeapons,
            'weapons' => $weapons,
            'purchases' => $purchases,
            'heroes' => $heroes,
            'quests' => $quests,
            'createdQuests' => $createdQuests,
            'joinedQuests' => $joinedQuests
        ]);
        }
}
