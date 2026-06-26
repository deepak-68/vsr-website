<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RedirectIfNotAuthenticatedForCheckout
{
    public function handle(Request $request, Closure $next)
    {
        // Allow AJAX requests (for OTP, shipping calc, etc.)
        if ($request->ajax() || $request->wantsJson()) {
            return $next($request);
        }
        
        // Check if accessing checkout routes without auth
        if (!auth()->check() && str_starts_with($request->path(), 'checkout')) {
            
            // Preserve cart & wishlist before redirect
            if (Session::has('cart')) {
                Session::put('cart_before_auth', Session::get('cart'));
            }
            if (Session::has('wishlist')) {
                Session::put('wishlist_before_auth', Session::get('wishlist'));
            }
            
            // Redirect to OTP auth page with return URL
            return redirect()
                ->route('auth.checkout-required')
                ->with('return_url', url()->current())
                ->with('info', 'Please verify your email to proceed with checkout');
        }
        
        // If authenticated, restore preserved data
        if (auth()->check() && Session::has('cart_before_auth')) {
            $existingCart = Session::get('cart', []);
            $preservedCart = Session::get('cart_before_auth', []);
            Session::put('cart', array_merge($existingCart, $preservedCart));
            Session::forget('cart_before_auth');
        }
        
        return $next($request);
    }
}