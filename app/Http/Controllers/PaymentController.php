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
        // Kod do przetwarzania płatności i tworzenia wypożyczenia
        $paymentData = $request->all();
        $user = Auth::user();
        $cart = session()->get('cart', []);
        $totalPrice = $paymentData['totalPrice'];
        $startDate = $paymentData['startDate'];
        $endDate = $paymentData['endDate'];

        // Tworzenie wypożyczenia w bazie danych
        $loan = $this->createLoan($user, $cart, $totalPrice, $startDate, $endDate);

        try {
            // Przetwarzanie płatności
            $paymentStatus = $this->processPaymentTransaction($request);

            // Aktualizacja statusu wypożyczenia na podstawie płatności
            if ($paymentStatus === 'succeeded') {
                $this->updateLoanStatus($loan, 'Opłacone');
                return redirect()->route('payment_success');
            } else {
                $this->updateLoanStatus($loan, 'Nieopłacone');
                throw new \Exception(session()->get('error'));
            }
        } catch (\Exception $e) {
            $errorMessage = '';
            switch ($e->getMessage()) {
                case 'Your card was declined.':
                    $errorMessage = __('Karta została odrzucona. Prosimy spróbować inną kartę płatniczą.');
                    break;
                case 'Your card has expired.':
                    $errorMessage = __('Karta płatnicza wygasła. Prosimy podać ważną kartę płatniczą.');
                    break;
                case 'Your card\'s security code is incorrect.':
                    $errorMessage = __('Nieprawidłowy kod CVC. Prosimy sprawdzić poprawność wprowadzonego kodu.');
                    break;
                case 'An error occurred while processing your payment.':
                    $errorMessage = __('Wystąpił błąd podczas przetwarzania płatności. Prosimy spróbować ponownie.');
                    break;
                case 'Your card number is incorrect.':
                    $errorMessage = __('Nieprawidłowy numer karty. Prosimy sprawdzić poprawność wprowadzonego numeru.');
                    break;
                default:
                    $errorMessage = __('Wystąpił błąd podczas przetwarzania płatności. Spróbuj ponownie później.');
                    break;
            }
            return redirect()->route('payment_error')->with('error', $errorMessage);
        }
    }

    public function processPaymentLateFee(Request $request)
    {
        // Kod do przetwarzania płatności kary
        try {
            // Przetwarzanie płatności
            $paymentStatus = $this->processPaymentTransaction($request);
            // Aktualizacja statusu wypożyczenia na podstawie płatności
            if ($paymentStatus === 'succeeded') {
            $user = Auth::user();
            $user->late_fee = 0;
            $user->save();
            return redirect()->back()->with('success', 'Kara została opłacona.');
        } else {
            throw new \Exception(session()->get('error'));
            }
        } catch (\Exception $e) {
            $errorMessage = '';
            switch ($e->getMessage()) {
                case 'Your card was declined.':
                    $errorMessage = __('Karta została odrzucona. Prosimy spróbować inną kartę płatniczą.');
                    break;
                case 'Your card has expired.':
                    $errorMessage = __('Karta płatnicza wygasła. Prosimy podać ważną kartę płatniczą.');
                    break;
                case 'Your card\'s security code is incorrect.':
                    $errorMessage = __('Nieprawidłowy kod CVC. Prosimy sprawdzić poprawność wprowadzonego kodu.');
                    break;
                case 'An error occurred while processing your payment.':
                    $errorMessage = __('Wystąpił błąd podczas przetwarzania płatności. Prosimy spróbować ponownie.');
                    break;
                case 'Your card number is incorrect.':
                    $errorMessage = __('Nieprawidłowy numer karty. Prosimy sprawdzić poprawność wprowadzonego numeru.');
                    break;
                default:
                    $errorMessage = __('Wystąpił błąd podczas przetwarzania płatności. Spróbuj ponownie później.');
                    break;
            }
            return redirect()->back()->withErrors($errorMessage);
        }
    }

    public function processPaymentLate(Request $request)
    {
        // Kod do przetwarzania płatności za opóźnienie w wypożyczeniu
        try {
            // Przetwarzanie płatności
            $paymentStatus = $this->processPaymentTransaction($request);
            // Aktualizacja statusu wypożyczenia na podstawie płatności
            if ($paymentStatus === 'succeeded') {
            $loanId = $request->input('loanId');
            $loan = Loan::find($loanId);
            $this->updateLoanStatus($loan, 'Opłacony');
            return redirect()->back()->with('success', 'Płatność przeszła.');
        } else {
            throw new \Exception(session()->get('error'));
            }
        } catch (\Exception $e) {
            $errorMessage = '';
            switch ($e->getMessage()) {
                case 'Your card was declined.':
                    $errorMessage = __('Karta została odrzucona. Prosimy spróbować inną kartę płatniczą.');
                    break;
                case 'Your card has expired.':
                    $errorMessage = __('Karta płatnicza wygasła. Prosimy podać ważną kartę płatniczą.');
                    break;
                case 'Your card\'s security code is incorrect.':
                    $errorMessage = __('Nieprawidłowy kod CVC. Prosimy sprawdzić poprawność wprowadzonego kodu.');
                    break;
                case 'An error occurred while processing your payment.':
                    $errorMessage = __('Wystąpił błąd podczas przetwarzania płatności. Prosimy spróbować ponownie.');
                    break;
                case 'Your card number is incorrect.':
                    $errorMessage = __('Nieprawidłowy numer karty. Prosimy sprawdzić poprawność wprowadzonego numeru.');
                    break;
                default:
                    $errorMessage = __('Wystąpił błąd podczas przetwarzania płatności. Spróbuj ponownie później.');
                    break;
            }
            return redirect()->back()->withErrors($errorMessage);
        }
    }

    private function createLoan($user, $cart, $totalPrice, $startDate, $endDate)
    {
        // Kod do tworzenia wypożyczenia w bazie danych
        $loan = new Loan();
        $loan->start_loan = $startDate;
        $loan->end_loan = $endDate;
        $loan->price = $totalPrice;
        $loan->status = 'Nieopłacone';
        $loan->user_id = $user->id;
        $loan->save();

        foreach ($cart as $movieId) {
            $loan->movies()->attach($movieId->id, ['loan_id' =>  $loan->id]);
            // Aktualizacja kolumny 'available' dla filmu
            $movieId->available = 'niedostępny';
            $movieId->save();
        }
        session()->forget('cart');
        session()->save();
        return $loan;
    }

    private function processPaymentTransaction(Request $request)
    {
        // Kod do przetwarzania płatności za pomocą Stripe
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
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

            return $paymentStatus;
        } catch (\Exception $e) {
            return redirect()->route('payment_error')->with('error', $e->getMessage());
            }
    }

    private function updateLoanStatus($loan, $status)
    {
        $loan->status = $status;
        $loan->save();
    }

    public function paymentSuccess()
    {
        $user = Auth::user();
        $latestLoanMovies = $this->getLatestLoanMovies($user);
        return view('payment.success', ['latestLoanMovies' => $latestLoanMovies]);
    }

    public function paymentError()
    {
        $errorMessage = session()->get('error');
        return view('payment.error', ['errorMessage' => $errorMessage]);
    }
    private function getLatestLoanMovies($user)
    {
        $latestLoan = Loan::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        if ($latestLoan) {
            return $latestLoan->movies;
        }
        return [];
    }
}
