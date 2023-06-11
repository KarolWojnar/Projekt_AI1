<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;

class LoansController extends Controller
{
    public function show($id)
        {
            $movie = Movie::find($id);

            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Musisz być zalogowany, aby wypożyczyć film.');
            }

            if ($movie->available === 'niedostępny') {
                return redirect()->back()->with('error', 'Ten film jest niedostępny.');
            }

            return view('loans.show', ['movie' => $movie]);
        }

    public function rentMovie($id)
        {
            $movie = Movie::find($id);
            $userId = Auth::id();
            $user = User::find($userId);

            if ($movie->available === 'niedostępny') {
                return redirect()->back()->with('error', 'Ten film jest niedostępny.');
            }

            return view('loans.show', ['movie' => $movie,'user' => $user]);

        }

        public function calculatePrice(Request $request): JsonResponse
        {
            $movieId = $request->input('movieId');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $cost = 0;

            DB::statement('CALL calculateThePrice(?, ?, ?, @cost)', [$movieId, $startDate, $endDate]);
            $result = DB::select('SELECT @cost AS cost');

            if (!empty($result)) {
                $cost = $result[0]->cost;
            }

            Session::put('priceResult', $cost);
            return response()->json(['success' => true, 'price' => $cost]);
        }



}
