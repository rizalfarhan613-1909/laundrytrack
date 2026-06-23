<?php

namespace App\Http\Middleware;

Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login, atau login tapi BUKAN super_admin, tendang balik
        if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman CEO.');
        }

        return $next($request);
    }
}