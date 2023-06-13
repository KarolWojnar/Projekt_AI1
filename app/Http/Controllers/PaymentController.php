<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Request $request)
    {
        $paymentData = $request->all();
        $user = Auth::user();
        $cart = session()->pull('cart', []);
        $totalPrice = $paymentData['priceResult2'];
        $startDate = $paymentData['startDate'];
        $endDate = $paymentData['endDate'];
        return view('payment.index', ['user' => $user, 'cart' => $cart, 'totalPrice' => $totalPrice, 'startDate' => $startDate, 'endDate' => $endDate]);
    }
    public function processPayment(Request $request)
    {
        // Ustawienie klucza tajnego Stripe
        Stripe::setApiKey('sk_test_51NI4MxBaqWYTYCZyzt2YuKVk3MOqAbdZDDQNrqhLJLVnAvviWKzSfn7vujXRnpGPQTF0l2JOx2peihenc4YCdJGN00TDyQ12BC');

        // Utworzenie płatności na podstawie tokenu płatności
        $token = $request->input('stripeToken');
        $totalPrice = session()->get('totalPrice');
        dd($token);

        try {
            Charge::create([
                'amount' => $totalPrice,
                'currency' => 'pln', // Waluta
                'description' => 'Opłata za wypożyczenie filmu',
                'source' => $token,
            ]);

            // Płatność zakończona sukcesem
            return redirect()->route('payment_success');
        } catch (\Exception $e) {
            // Obsługa błędu płatności
            return redirect()->route('payment_error')->with('error', $e->getMessage());
        }
    }


    public function paymentSuccess()
    {
        session()->forget('cart');
        session()->save();
        return redirect()->route('payment_success');
    }

    public function paymentError()
    {
        // Strona obsługi błędu płatności
        return view('payment.error');
    }
}
