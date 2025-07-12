<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubmissionRequest;
use App\Models\Submission;

class SubmissionController extends Controller
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
    public function store(SubmissionRequest $submissionRequest)
    {
        $data = $submissionRequest->validated();

            // Verificar si ya existe una submission de este héroe para esta quest
            $alreadySubmitted = Submission::where('heroe_id', $data['heroe_id'])
                ->where('quest_id', $data['quest_id'])
                ->exists();

            if ($alreadySubmitted) {
                return redirect()->back()->withErrors([
                    'submission' => 'Submission already sent with this hero',
                ])->withInput();
            }

            // Si no existe, se guarda
            $submission = Submission::create([
                'heroe_id' => $data['heroe_id'],
                'quest_id' => $data['quest_id'],
                'description' => $data['description'],
                'status' => 'pending',
            ]);

            return redirect()->back()->with('success', 'Submission successfuly sent.');
        
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
