<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Heroe;
use App\Models\Quest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $purchases = $user->purchases()->get();
        $heroes = $user->heroes()->with('equipments.purchase.weapon')->get();
        $quests = Quest::with('user')->get();
        $createdQuests = $user->quests()->with('user')->latest()->get();
        $heroIds = $user->heroes()->pluck('id');
        $joinedQuests = Quest::whereHas('heroes', function ($query) use ($heroIds) {
        $query->whereIn('heroes.id', $heroIds);
        })->with('user')->latest()->get();
        return inertia ('Quests/Index', [
            'purchases' => $purchases,
            'heroes' => $heroes,
            'quests' => $quests,
            'createdQuests' => $createdQuests,
            'joinedQuests' => $joinedQuests
        ]);
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
    public function destroy(string $id)
    {
        //
    }
}
