<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    /**
     * Handle an incoming request.
     * Usage: add middleware 'role:admin, guru_bk' in route definition.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if (!$user) {
            abort(403);
        }

        $roleName = optional($user->role)->name;
        if (!$roleName || ($roles && !in_array($roleName, $roles))) {
            abort(403);
        }

        return $next($request);
    }
}
