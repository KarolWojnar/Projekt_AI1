<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpinionController extends Controller
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
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'content' => 'required',
        ]);

        $opinion = new Opinion();
        $opinion->user_id = Auth::id();
        $opinion->movie_id = $validatedData['movie_id'];
        $opinion->content = $validatedData['content'];
        $opinion->save();

        return back()->with('success', 'Opinia została dodana.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Opinion $opinion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opinion $opinion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opinion $opinion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opinion $opinion)
    {
        //
    }
}
