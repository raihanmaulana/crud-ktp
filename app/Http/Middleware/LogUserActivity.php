<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek jika pengguna login dan role-nya adalah 'user'
        if (Auth::check() && Auth::user()->role === 'user') {
            $data = UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => $request->method() . ' ' . $request->path(),
                'url' => $request->fullUrl(),
                'created_at' => now(),
            ]);
        }

        // Lanjutkan ke request berikutnya
        return $next($request);
    }
}
