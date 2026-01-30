<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdvancedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if($user == null) {
            return redirect()->route('login');
        } elseif($user->rol == 'advanced' || $user->rol == 'admin') {
            return $next($request);
        } else {
            return redirect()->route('home');
        }
    }
}
