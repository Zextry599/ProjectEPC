<?php

namespace App\Http\Middleware;

use Auth;
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
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        \Log::info('CheckRole middleware dipanggil dengan roles: ' . implode(',', $roles));
        if (!Auth::check()) {
            \Log::info('CheckRole: Pengguna belum login, redirect ke login');
            return redirect()->route('login');
        }

        $user = Auth::user();
        \Log::info('CheckRole: Pengguna ditemukan, role: ' . ($user->role ?? 'tidak ada'));
        if (!$user || !in_array($user->role, $roles)) {
            \Log::info('CheckRole: Akses ditolak, role tidak cocok');
            abort(403, 'Unauthorized');
        }

        \Log::info('CheckRole: Akses diizinkan, melanjutkan request');
        return $next($request);
    }
}
