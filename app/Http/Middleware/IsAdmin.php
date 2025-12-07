<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            // If user is staff, redirect to staff dashboard
            if (Auth::user()->role === 'staff') {
                return redirect()->route('staff.dashboard');
            }
            
            // For any other role, deny access
            return redirect('/dashboard')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}