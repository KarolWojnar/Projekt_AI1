<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
class MoviesController extends Controller
{
    public function index()
{
    $movies = Movie::all();

    return view('movies.index', compact('movies'));
}

public function delete($id)
{
    $movie = Movie::find($id);

    if (!$movie) {
        // Jeśli film o podanym identyfikatorze nie istnieje, możesz wyświetlić odpowiedni komunikat lub przekierować użytkownika na inną stronę.
        return redirect()->back()->with('error', 'Film nie został znaleziony.');
    }

    $movie->delete();

    return redirect()->back()->with('success', 'Film został pomyślnie usunięty.');
}
}
