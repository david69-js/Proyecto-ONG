<?php
// app/Http/Middleware/CaptureClientInfo.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivitySession;

class CaptureClientInfo
{
    public function handle(Request $request, Closure $next)
    {
        // si quieres iniciar session en la primera petición de la app
        $sessionKey = $request->cookie('activity_session') ?? bin2hex(random_bytes(12));
        // adjunta cookie a la respuesta más abajo.

        // Puedes crear/actualizar un registro básico (no pesado)
        ActivitySession::updateOrCreate(
            ['session_key' => $sessionKey],
            [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'last_seen_at' => now(),
                'current_path' => $request->path(),
                'started_at' => now()->subSeconds(0), // si quieres
            ]
        );

        $response = $next($request);
        // set cookie si no estaba
        if (! $request->cookie('activity_session')) {
            $response->cookie('activity_session', $sessionKey, 60*24*30); // 30 días
        }
        return $response;
    }
}
