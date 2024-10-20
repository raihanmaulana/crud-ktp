<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();

        // Jika user tidak ada atau role tidak sesuai
        if (!$user || $user->role !== $role) {
            return redirect()->route('no.access', ['role' => $user ? $user->role : 'guest']);
        }

        return $next($request);
    }
}
