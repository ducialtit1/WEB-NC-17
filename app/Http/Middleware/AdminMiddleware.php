<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            // Chuyển từ route('home') sang redirect('/')
            return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực này');
        }
        
        return $next($request);
    }
}