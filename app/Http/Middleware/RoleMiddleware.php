<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Send each role to its own area instead of trapping the user in a
            // 403 loop (the error page's "Go Home" link points to `/`).
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->role === 'client') {
                return redirect()->route('home');
            }

            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
