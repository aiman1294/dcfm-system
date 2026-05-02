<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
      */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }
    public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'pending') {
        return redirect('/')->with('error', 'Wait for admin approval');
    }

    return $next($request);
}
}
