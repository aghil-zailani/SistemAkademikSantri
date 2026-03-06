<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin can access everything
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if user has any of the required roles
        if ($user->hasRole($roles)) {
            return $next($request);
        }

        // User doesn't have permission
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}