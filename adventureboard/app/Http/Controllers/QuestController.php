<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Heroe;
use App\Models\Quest;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\QuestRequest;

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
        return Inertia::render('Quests/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();


         if ($user->coins < $validated['reguard']) {

            return redirect()->back()->withErrors(['coins' => 'No tienes suficientes monedas para crear esta quest.']);
        }
        
        $difficulty = match (true) {
            $validated['reguard'] < 20 => 'easy',
            $validated['reguard'] < 200 => 'medium',
            default => 'hard',
        };

        
        if ($request->hasFile('image_uri')) {
            $path = $request->file('image_uri')->store('quests', 'public');
            $validated['image_uri'] = $path;
        } else {
            $validated['image_uri'] = 'Quests_images/default.jpg';
        }

        $user->coins -= $validated['reguard'];
        $user->save();

        
        Quest::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'strength_required' => $validated['strength_required'] ?? 20,
            'defense_required' => $validated['defense_required'] ?? 20,
            'ki_required' => $validated['ki_required'] ?? 20,
            'reguard' => $validated['reguard'],
            'image_uri' => $validated['image_uri'] ?? null,
            'difficulty' => $difficulty,
            'status' => 'open'
        ]);

        return redirect()->route('quests.index')->with('success', 'Quest created successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $quest = Quest::with('user')->findOrFail($id);
        $submissions = Submission::with('heroe.user')->where('quest_id', $quest->id)->get();
        
        $isCreatedByUser = $quest->user_id === $user->id;
        
        $purchases = $user->purchases()->get();
        $heroes = $user->heroes()->with('equipments.purchase.weapon')->get();
        $quests = Quest::with('user')->get();
        $createdQuests = $user->quests()->with('user')->latest()->get();
        $heroIds = $user->heroes()->pluck('id');
        $joinedQuests = Quest::whereHas('heroes', function ($query) use ($heroIds) {
        $query->whereIn('heroes.id', $heroIds);
        })->with('user')->latest()->get();

        return inertia('Quests/QuestId', [
            'quest' => $quest,
            'purchases' => $purchases,
            'heroes' => $heroes,
            'quests' => $quests,
            'createdQuests' => $createdQuests,
            'joinedQuests' => $joinedQuests,
            'isCreatedByUser' => $isCreatedByUser,
            'submissions' => $submissions
        ]);
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
