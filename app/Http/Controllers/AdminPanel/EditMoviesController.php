<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class EditMoviesController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('adminPanel.editMovies', compact('movies'));
    }
}
