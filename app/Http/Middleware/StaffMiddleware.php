<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has staff role
        if (!auth()->user()->isStaff()) {
            // If user is admin, redirect to admin dashboard
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            // For any other role, deny access
            abort(403, 'Unauthorized access. Staff privileges required.');
        }

        return $next($request);
    }
}