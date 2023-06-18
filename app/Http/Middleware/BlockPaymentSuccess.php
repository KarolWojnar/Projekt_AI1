<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockPaymentSuccess
{
    public function handle($request, Closure $next)
    {
        // Sprawdź, czy żądana trasa to "/payment/success"
        if ($request->is('payment/success')) {
            // Możesz przekierować użytkownika na inną stronę
            return redirect('/');
        }

        return $next($request);
    }
}
