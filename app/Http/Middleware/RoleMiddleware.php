<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();
        if (strpos($role, ':class:') === 0) {
            $role = substr($role, 7);
        }
        if (! $user || $user->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
