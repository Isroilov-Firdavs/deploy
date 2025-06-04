<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Agar foydalanuvchi allaqachon tizimga kirgan bo‘lsa, asosiy sahifaga yo‘naltir
        if (Session::get('is_logged_in')) {
            return redirect()->route('home'); // asosiy sahifa route
        }

        return $next($request);
    }
}
