<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MoviesController extends Controller
{
    public function index()
    {
        $loansAll = Loan::all();
        $today = Carbon::today()->startOfDay();
        foreach ($loansAll as $loan)
        {
            $expectDate = Carbon::parse($loan->start_loan);
            if ($today->greaterThan($expectDate) && $loan->status == 'Nieopłacone') {
                foreach ($loan->movies as $movie) {
                    $movie->available = 'dostępny';
                    $movie->save();
                }
                $loan->movies()->detach();
                $loan->delete();
            }
        }
        $movies = Movie::all();
        $categories = Category::all();

        return view('movies.filter', ['movies' => $movies, 'categories' => $categories, 'idSelected' => 0, 'idSorted' => ' ']);
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
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'director' => 'required',
            'release' => ['required', 'date_format:Y'],
            'longTime' => ['required', 'numeric', 'between:1,1000'],
            'img_path' => 'nullable|image|max:64',
            'rate' => ['required', 'numeric', 'between:0,10'],
            'pricePerDay' => ['required', 'numeric', 'between:0,100'],
            'available' => 'required',
        ]);

        $movie = Movie::find($id);
        $movie->title = $request->input('title');
        $movie->category_id = $request->input('category_id');
        $movie->director = $request->input('director');
        $movie->description = $request->input('description');
        $movie->release = $request->input('release');
        $movie->longTime = $request->input('longTime');
        $movie->rate = $request->input('rate');
        $movie->pricePerDay = $request->input('pricePerDay');
        $movie->available = $request->input('available');

        if ($request->hasFile('img_path')) {
            $file = $request->file('img_path');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('', $fileName);

            $imagePath = public_path('images/'.$fileName);
            $imageData = file_get_contents($imagePath);
            $movie->img_path = $imageData;
        }

        $movie->save();

        return redirect()->route('editMovies')->with('success', 'Film został zaktualizowany.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'director' => 'required',
            'release' => ['required', 'date_format:Y'],
            'longTime' => ['required', 'numeric', 'between:1,1000'],
            'img_path' => 'required|image|max:64',
            'rate' => ['required', 'numeric', 'between:0,10'],
            'pricePerDay' => ['required', 'numeric', 'between:0,100'],
            'available' => 'required',
        ]);

        if ($request->hasFile('img_path')) {
            $file = $request->file('img_path');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('', $fileName);

            $imagePath = public_path('images/'.$fileName);
            $imageData = file_get_contents($imagePath);

            $movie = new Movie();
            $movie->img_path = $imageData;
            $movie->title = $request->input('title');
            $movie->category_id = $request->input('category_id');
            $movie->description = $request->input('description');
            $movie->director = $request->input('director');
            $movie->release = $request->input('release');
            $movie->longTime = $request->input('longTime');
            $movie->rate = $request->input('rate');
            $movie->pricePerDay = $request->input('pricePerDay');
            $movie->available = $request->input('available');

            $movie->save();

            return redirect()->back()->with('success', 'Film został dodany pomyślnie.');
        }

        return redirect()->back()->with('error', 'Wystąpił problem z przesłanym plikiem.');
    }

        public function catStore(Request $request)
        {

            $request->validate([
                'genre' => 'required|unique:categories',
            ]);
            $category = new Category();
            $category->genre = $request->input('genre');

            $category->save();

            return redirect()->back()->with('success', 'Kategoria została dodana pomyślnie.');
        }

        public function show($id)
        {
            $movie = Movie::find($id);
            $user = Auth::user();
            $currentDate = Carbon::now()->toDateString();

            $loans = collect();
            $cart = session()->get('cart', []);

            // Sprawdź, czy użytkownik jest zalogowany
            if ($user) {
                $loans = Loan::where('user_id', $user->id)
                    ->where(function ($query) use ($currentDate) {
                        $query->where('status', 'Nieopłacone')
                            ->orWhere('end_loan', '<', $currentDate);
                    })
                    ->get();
            }
            $idSelected = 0;
            $idSorted = '';

            return view('movies.show', compact('movie', 'cart', 'user', 'loans', 'idSelected', 'idSorted'));
        }


        public function searchMovies(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $movies = Movie::query();

        if ($search) {
            $movies->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%");
            });
        }

        $movies = $movies->get();
        $categories = Category::all();
        $idSelected = 0;
        $idSorted = '';

        return view('movies.filter', compact('movies', 'categories', 'idSelected', 'idSorted'));
    }

    public function filter(Request $request)
        {
            $genre = $request->genre;
            $sortBy = $request->sort_by;
            $categories = Category::all();

            $query = Movie::query();
            $idSelected = 0;

            if ($genre && $genre !== 'all') {
                $query->where('category_id', $genre);
                $idSelected = $genre;
            }
            $idSorted = '';
            if ($sortBy) {
                if ($sortBy === 'release1') {
                    $query->orderBy('release', 'desc');
                    $idSorted = 'release1';
                } elseif ($sortBy === 'release2') {
                    $query->orderBy('release', 'asc');
                    $idSorted = 'release2';
                } elseif ($sortBy === 'rate1') {
                    $query->orderBy('rate', 'asc');
                    $idSorted = 'rate1';
                } elseif ($sortBy === 'rate2') {
                    $query->orderBy('rate', 'desc');
                    $idSorted = 'rate2';
                } elseif ($sortBy === 'length1') {
                    $query->orderBy('longTime', 'asc');
                    $idSorted = 'length1';
                } elseif ($sortBy === 'length2') {
                    $query->orderBy('longTime', 'desc');
                    $idSorted = 'length2';
                }
            }

            $movies = $query->get();
            return view('movies.filter', ['movies' => $movies,'categories' => $categories, 'idSelected' => $idSelected, 'idSorted' => $idSorted]);
        }

        public function getMovieImage($id)
        {
            $movie = Movie::findOrFail($id);

            $image = $movie->img_path;

            return response($image)->header('Content-Type', 'image/jpeg');
        }

}
