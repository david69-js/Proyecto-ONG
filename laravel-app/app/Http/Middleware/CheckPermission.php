<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        $user = auth()->user();

        // Super admin siempre pasa (bypass)
        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        // Verificar si tiene el permiso
        if (!$user->hasPermission($permission)) {
            abort(403, 'No tienes permiso para acceder a esta funcionalidad.');
        }

        return $next($request);
    }
}