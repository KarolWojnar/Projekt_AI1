<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('totalAmount', $this->getTotalAmount());
    }
    public function getTotalAmount()
    {
        $cart = session()->get('cart', []);
        $totalAmount = count($cart);
        return $totalAmount;
    }
}
