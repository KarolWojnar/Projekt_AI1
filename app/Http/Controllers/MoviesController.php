<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MoviesController extends Controller
{
    public function index()
    {
        $movies = Movie::all();

        return view('movies.filter', ['movies' => $movies]);
    }

    public function delete($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {

            return redirect()->back()->with('error', 'Film nie został znaleziony.');
        }

        $movie->delete();

        return redirect()->back()->with('success', 'Film został pomyślnie usunięty.');
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);
        $movie->title = $request->input('title');
        $movie->genre = $request->input('genre');
        $movie->director = $request->input('director');
        $movie->release = $request->input('release');
        $movie->longTime = $request->input('longTime');
        $movie->rate = $request->input('rate');
        $movie->img_path = $request->input('img_path');
        $movie->pricePerDay = $request->input('pricePerDay');
        $movie->available = $request->input('available');
        $movie->save();

        return redirect()->route('editMovies')->with('success', 'Film został zaktualizowany.');
    }

    public function store(Request $request)
        {

            $request->validate([
                'title' => 'required',
                'genre' => 'required',
                'description' => 'required',
                'director' => 'required',
                'release' => 'required',
                'longTime' => 'required',
                'img_path' => 'required',
                'rate' => 'required',
                'pricePerDay' => 'required',
                'available' => 'required',
            ]);

            $movie = new Movie();
            $movie->title = $request->input('title');
            $movie->genre = $request->input('genre');
            $movie->description = $request->input('description');
            $movie->director = $request->input('director');
            $movie->release = $request->input('release');
            $movie->longTime = $request->input('longTime');
            $movie->rate = $request->input('rate');
            $movie->img_path = $request->input('img_path');
            $movie->pricePerDay = $request->input('pricePerDay');
            $movie->available = $request->input('available');

            $movie->save();

            return redirect()->back()->with('success', 'Film został dodany pomyślnie.');
        }

    public function show($id)
        {
            $movie = Movie::find($id);
            $user = Auth::user();
            $cart = session()->get('cart', []);

            return view('movies.show', ['movie' => $movie, 'cart' => $cart, 'user' => $user]);
        }
    public function searchMovies(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $movies = Movie::query();

        if ($search) {
            $movies->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhereHas('actors', function ($query) use ($search) {
                        $query->where('actor_name', 'like', "%$search%");
                    });
            });
        }
        return view('movies.filter', compact('movies', 'categories'));
    }

    public function filter(Request $request)
        {
            $genre = $request->genre;
            $sortBy = $request->sort_by;

            $query = Movie::query();

            if ($genre && $genre !== 'all') {
                $query->where('genre', $genre);
            }

            if ($sortBy) {
                if ($sortBy === 'release1') {
                    $query->orderBy('release', 'desc');
                } elseif ($sortBy === 'release2') {
                    $query->orderBy('release', 'asc');
                } elseif ($sortBy === 'rate1') {
                    $query->orderBy('rate', 'asc');
                } elseif ($sortBy === 'rate2') {
                    $query->orderBy('rate', 'desc');
                } elseif ($sortBy === 'length1') {
                    $query->orderBy('longTime', 'asc');
                } elseif ($sortBy === 'length2') {
                    $query->orderBy('longTime', 'desc');
                }
            }

            $movies = $query->get();

            return view('movies.filter', ['movies' => $movies]);
        }

}
