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
    public function handle(Request $request, Closure $next, string $roleSlug): Response
    {
        if (!auth()->check() || !auth()->user()->hasRole($roleSlug)) {
            abort(403, 'Zugriff verweigert.');
        }

        return $next($request);
    }
}