<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Request $request)
    {
        $paymentData = $request->all();
        $user = Auth::user();
        $cart = session()->get('cart', []);
        $totalPrice = $paymentData['priceResult2'];
        $startDate = $paymentData['startDate'];
        $endDate = $paymentData['endDate'];
        return view('payment.index', ['user' => $user, 'cart' => $cart, 'totalPrice' => $totalPrice, 'startDate' => $startDate, 'endDate' => $endDate]);
    }
    public function show2(Request $request)
    {
        $paymentData = $request->all();
        $user = Auth::user();
        $totalPrice = $paymentData['late_fee'];
        return view('payment.late_fee', ['user' => $user, 'totalPrice' => $totalPrice]);
    }



    public function processPayment(Request $request)
    {
        // Ustawienie klucza tajnego Stripe
        $stripe = new \Stripe\StripeClient('sk_test_51NI4MxBaqWYTYCZyzt2YuKVk3MOqAbdZDDQNrqhLJLVnAvviWKzSfn7vujXRnpGPQTF0l2JOx2peihenc4YCdJGN00TDyQ12BC');


        // Utworzenie płatności na podstawie tokenu płatności
        $token = $request->input('stripeToken');
        $source = $stripe->sources->create([
            'type' => 'card',
            'token' => $token,
        ]);
        $totalPrice = $request->input('totalPrice');

        try {
            $stripe->paymentIntents->create([
                'amount' => $totalPrice*100,
                'currency' => 'pln',
                'description' => 'Opłata za wypożyczenie filmu',
                'source' => $source->id,
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
        $user = Auth::user();
        $user->late_fee = 0;
        $user->save();
        session()->forget('cart');
        session()->save();
        return view('payment.success');
    }

    public function paymentError()
    {
        // Strona obsługi błędu płatności
        return view('payment.error');
    }
}
