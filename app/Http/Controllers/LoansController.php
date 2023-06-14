<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;

class LoansController extends Controller
{
        public function cartMovie($id)
        {
            $movie = Movie::find($id);
            if (!$movie) {
                return redirect()->back()->with('error', 'Film o podanym ID nie został znaleziony.');
            }
            $cart = session()->pull('cart', []);
            $cart[] = $movie;
            $totalAmount = count($cart);
            session()->put('totalAmount', $totalAmount);
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Film został dodany do koszyka.');
        }

        public function deleteFromCart($id)
        {
            $cart = session()->get('cart', []);

            $updatedCart = array_filter($cart, function ($movie) use ($id) {
                return $movie->id != $id;
            });

            session()->put('cart', $updatedCart);
            return redirect()->route('loans.show')->with('success', 'Film został usunięty z koszyka.');
        }

        public function cartShow()
        {
            $user = Auth::user();
            $cart = session()->get('cart', []);
            $totalPrice = 0;
            $sum = 0;
            foreach ($cart as $movie) {
                $totalPrice += $movie->pricePerDay;
                $sum += 1;
            }
            $prom = 0.05 * $sum;
            if ($prom >= 0.3) $prom = 0.3;
            $totalPrice = $totalPrice * (1 - $prom);

            return view('loans.show', [
                'user' => $user,
                'cart' => $cart,
                'totalPrice' => $totalPrice,
                'sum' => $sum,
                'prom' => $prom
            ]);
        }
        public function loansShowAll()
        {
            $loans = Loan::all();
            return view('loans.all', ['loans' => $loans]);
        }

}
