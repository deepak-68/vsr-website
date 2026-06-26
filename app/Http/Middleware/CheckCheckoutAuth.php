<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckCheckoutAuth
{
     public function handle(Request $request, \Closure $next)
    {
        if (!auth()->check()) {
            // Preserve cart before redirect
            session()->put('cart_before_auth', session()->get('cart', []));
            
            return redirect()
                ->route('login')
                ->with('return_url', url()->current())
                ->with('info', 'Please login or register to proceed with checkout');
        }
        
        return $next($request);
    }
}