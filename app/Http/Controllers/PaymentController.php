<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\Loan;

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


    public function processPayment(Request $request)
    {
        // Ustawienie klucza tajnego Stripe
        $stripe = new \Stripe\StripeClient('SECRET KEY');
        // Utworzenie płatności na podstawie tokenu płatności
        $token = $request->input('stripeToken');
        $source = $stripe->sources->create([
            'type' => 'card',
            'token' => $token,
        ]);
        $totalPrice = $request->input('totalPrice');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $user = Auth::user();
        $cart = session()->get('cart',  collect());
        $loan = new Loan();
        $loan->start_loan = $startDate;
        $loan->end_loan = $endDate;
        $loan->price = $totalPrice;
        $loan->status = 'Nieopłacone';
        $loan->user_id = $user->id;
        $loan->save();
        $loanId = $loan->id;

        foreach ($cart as $movieId) {
            $loan->movies()->attach($movieId->id, ['loan_id' =>  $loanId]);
            // Aktualizacja kolumny 'available' dla filmu
            $movieId->available = 'niedostępny';
            $movieId->save();
            session()->forget('cart');
            session()->save();
        }

        try {
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $totalPrice * 100,
                'currency' => 'pln',
                'description' => 'Opłata za wypożyczenie filmu',
                'source' => $source->id,
            ]);

            $paymentIntentId = $paymentIntent->id;
            $confirmedPaymentIntent = $stripe->paymentIntents->confirm($paymentIntentId);
            $paymentStatus = $confirmedPaymentIntent->status;

            if ($paymentStatus === 'succeeded') {
                    $loan->status = 'Opłacone';
                    $loan->save();
                    return redirect()->route('payment_success');
            } else {
                    $loan->status = 'Nieopłacone';
                    $loan->user_id = $user->id;
                    $loan->save();

                    return redirect()->route('payment_error')->with('error', 'Nieudana płatność.');
            }
        } catch (\Exception $e) {
            // Obsługa błędu płatności
            $loan->status = 'Nieopłacone';
            $loan->user_id = $user->id;
            $loan->save();
            return redirect()->route('payment_error')->with('error', $e->getMessage());
        }
    }


    public function processPayment_lateFee(Request $request)
    {
        // Ustawienie klucza tajnego Stripe
        $stripe = new \Stripe\StripeClient('SECRET KEY');
        // Utworzenie płatności na podstawie tokenu płatności
        $token = $request->input('stripeToken');
        $source = $stripe->sources->create([
            'type' => 'card',
            'token' => $token,
        ]);
        $totalPrice = $request->input('totalPrice');
        $user = Auth::user();

        try {
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $totalPrice * 100,
                'currency' => 'pln',
                'description' => 'Opłata za wypożyczenie filmu',
                'source' => $source->id,
            ]);

            $paymentIntentId = $paymentIntent->id;
            $confirmedPaymentIntent = $stripe->paymentIntents->confirm($paymentIntentId);
            $paymentStatus = $confirmedPaymentIntent->status;

            if ($paymentStatus === 'succeeded') {
                $user = Auth::user();
                $user->late_fee = 0;
                $user->save();

                return redirect()->back()->with('success', 'Płatność przeszła.');
            } else {
                return redirect()->route('payment_error')->with('error', 'Nieudana płatność.');
            }
        } catch (\Exception $e) {
            // Obsługa błędu płatności
            return redirect()->route('payment_error')->with('error', $e->getMessage());
        }
    }

    public function processPayment_late(Request $request)
    {
        // Ustawienie klucza tajnego Stripe
        $stripe = new \Stripe\StripeClient('SECRET KEY');
        // Utworzenie płatności na podstawie tokenu płatności
        $token = $request->input('stripeToken');
        $source = $stripe->sources->create([
            'type' => 'card',
            'token' => $token,
        ]);
        $totalPrice = $request->input('totalPrice');

        try {
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $totalPrice * 100,
                'currency' => 'pln',
                'description' => 'Opłata za wypożyczenie filmu',
                'source' => $source->id,
            ]);

            $paymentIntentId = $paymentIntent->id;
            $confirmedPaymentIntent = $stripe->paymentIntents->confirm($paymentIntentId);
            $paymentStatus = $confirmedPaymentIntent->status;

            if ($paymentStatus === 'succeeded') {
                $loanId = $request->input('loanId');
                $loan = Loan::find($loanId);
                $loan->status = 'Opłacony';
                $loan->save();

                return redirect()->back()->with('success', 'Płatność przeszła.');
            } else {
                return redirect()->route('payment_error')->with('error', 'Nieudana płatność.');
            }
        } catch (\Exception $e) {
            // Obsługa błędu płatności
            return redirect()->route('payment_error')->with('error', $e->getMessage());
        }
    }


    public function paymentSuccess()
    {
        return view('payment.success');
    }

    public function paymentError()
    {
        // Strona obsługi błędu płatności
        return view('payment.error');
    }
}
