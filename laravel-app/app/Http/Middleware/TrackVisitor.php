<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorTracking;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo trackear requests HTTP normales, no AJAX ni assets
        if ($this->shouldTrack($request)) {
            $this->trackVisit($request);
        }

        $response = $next($request);

        return $response;
    }

    /**
     * Determinar si debemos trackear esta request
     */
    private function shouldTrack(Request $request): bool
    {
        // No trackear requests AJAX, assets, o API
        if ($request->ajax() || 
            $request->is('api/*') || 
            $request->is('assets/*') || 
            $request->is('css/*') || 
            $request->is('js/*') || 
            $request->is('img/*') ||
            $request->is('vendor/*') ||
            $request->is('storage/*') ||
            $request->is('admin/visitor-tracking/*')) {
            return false;
        }

        // No trackear métodos que no sean GET
        if ($request->method() !== 'GET') {
            return false;
        }

        // No trackear bots conocidos
        $userAgent = $request->userAgent();
        $bots = ['bot', 'crawler', 'spider', 'scraper', 'facebook', 'twitter', 'linkedin'];
        
        foreach ($bots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Trackear la visita
     */
    private function trackVisit(Request $request): void
    {
        try {
            $sessionId = $request->session()->getId();
            $ipAddress = $this->getClientIp($request);
            $userAgent = $request->userAgent();
            $pageUrl = $request->fullUrl();
            $referrer = $request->header('referer');
            
            // Detectar información del dispositivo y navegador
            $deviceInfo = $this->parseUserAgent($userAgent);
            
            // Verificar si ya existe una visita activa para esta sesión y URL
            $existingVisit = VisitorTracking::where('session_id', $sessionId)
                ->where('page_url', $pageUrl)
                ->whereNull('visit_end')
                ->first();

            if ($existingVisit) {
                // Actualizar tiempo de visita existente
                $existingVisit->update([
                    'visit_end' => now(),
                    'time_spent' => now()->diffInSeconds($existingVisit->visit_start)
                ]);
            }

            // Crear nueva entrada de visita
            VisitorTracking::create([
                'session_id' => $sessionId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'page_url' => $pageUrl,
                'page_title' => $this->getPageTitle($request),
                'referrer' => $referrer,
                'visit_start' => now(),
                'device_type' => $deviceInfo['device_type'],
                'browser' => $deviceInfo['browser'],
                'page_data' => [
                    'route_name' => $request->route() ? $request->route()->getName() : null,
                    'controller' => $request->route() ? $request->route()->getActionName() : null,
                    'query_params' => $request->query(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error tracking visitor: ' . $e->getMessage());
        }
    }

    /**
     * Obtener IP real del cliente
     */
    private function getClientIp(Request $request): string
    {
        $ipKeys = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }

        return $request->ip();
    }

    /**
     * Parsear User Agent para obtener información del dispositivo
     */
    private function parseUserAgent(string $userAgent): array
    {
        $deviceType = 'desktop';
        $browser = 'unknown';

        // Detectar dispositivo
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i', $userAgent)) {
            $deviceType = 'mobile';
        } elseif (preg_match('/Tablet|iPad/i', $userAgent)) {
            $deviceType = 'tablet';
        }

        // Detectar navegador
        if (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        }

        return [
            'device_type' => $deviceType,
            'browser' => $browser
        ];
    }

    /**
     * Obtener título de la página
     */
    private function getPageTitle(Request $request): ?string
    {
        // Intentar obtener el título de la página desde la respuesta
        // Esto se puede mejorar con JavaScript en el frontend
        return null;
    }
}
