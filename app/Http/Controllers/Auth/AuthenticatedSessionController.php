<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Restore cart from database after login
        $user = Auth::user();
        $cart = \App\Models\Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $request->session()->put('cart', json_decode($cart->cart_data, true));
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Save cart to database before logout
        $user = Auth::user();
        $cart = $request->session()->get('cart', []);
        \Log::info('Cart before logout:', ['cart' => $cart, 'user_id' => $user ? $user->id : null]);
        if ($user && !empty($cart)) {
            \App\Models\Cart::updateOrCreate(
                ['user_id' => $user->id],
                ['cart_data' => json_encode($cart)]
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
