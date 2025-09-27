<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles  // الأدوار المسموح بها
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
/*
        $userRoles = $user->roles->pluck('name')->toArray();

        if (count(array_intersect($userRoles, $roles)) === 0) {
            return response()->json([
                'message' => 'Unauthorized: your role does not have access',
                'roles' => $userRoles
            ], 403);
        }*/
            $userRoles = $user->roles->pluck('name')->toArray();

if (count(array_intersect($userRoles, $roles)) === 0) {
    return response()->json([
        'message' => 'Unauthorized: your role does not have access',
        'roles' => $userRoles
    ], 403);
}

        return $next($request);
    }
}
