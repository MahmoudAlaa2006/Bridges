<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CandidateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * Check if user is authenticated and has the 'candidate' role.
         */
        if (Auth::check() && strtolower(Auth::user()->role) === 'candidate') {
            return $next($request);
        }

        /**
         * Redirect to login with error message if unauthorized.
         */
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }
}

