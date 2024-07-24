<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsurePatientIsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('patient')->check()) {
            return $next($request);
        }

        // Redirect to the login page or another appropriate route
        return redirect()->route('patient')->with('error', 'You must be logged in as a patient to access this page.');
        // return $next($request);
    }
}
