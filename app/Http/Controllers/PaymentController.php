<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function show()
    {
        return view('payment.index');
    }
    public function processPayment(Request $request)
    {
        // Ustawienie klucza tajnego Stripe
        Stripe::setApiKey('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');

        // Utworzenie płatności na podstawie tokenu płatności
        $token = $request->input('stripeToken');

        try {
            Charge::create([
                'amount' => 1000, // Kwota w groszach (np. 10 zł = 1000 groszy)
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
        // Strona potwierdzenia sukcesu płatności
        return view('payment.success');
    }

    public function paymentError()
    {
        // Strona obsługi błędu płatności
        return view('payment.error');
    }
}
