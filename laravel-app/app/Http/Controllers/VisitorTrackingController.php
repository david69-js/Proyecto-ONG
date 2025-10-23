<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorTracking;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class VisitorTrackingController extends Controller
{
    /**
     * Mostrar dashboard de estadísticas de visitantes
     */
    public function index()
    {
        $stats = [
            'visitor_stats' => VisitorTracking::getVisitorStats(7),
            'top_pages' => VisitorTracking::getTopPages(10),
            'active_visitors' => VisitorTracking::getActiveVisitors(5),
            'geographic_stats' => VisitorTracking::getGeographicStats(),
            'device_stats' => VisitorTracking::getDeviceStats(),
        ];

        return view('admin.visitor-tracking.index', compact('stats'));
    }

    /**
     * API: Obtener estadísticas de visitantes
     */
    public function getStats(Request $request): JsonResponse
    {
        $days = $request->get('days', 7);
        $stats = VisitorTracking::getVisitorStats($days);
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * API: Obtener visitantes activos en tiempo real
     */
    public function getActiveVisitors(Request $request): JsonResponse
    {
        $minutes = $request->get('minutes', 5);
        $activeVisitors = VisitorTracking::getActiveVisitors($minutes);
        
        return response()->json([
            'success' => true,
            'data' => $activeVisitors,
            'count' => $activeVisitors->count()
        ]);
    }

    /**
     * API: Obtener páginas más visitadas
     */
    public function getTopPages(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $topPages = VisitorTracking::getTopPages($limit);
        
        return response()->json([
            'success' => true,
            'data' => $topPages
        ]);
    }

    /**
     * API: Obtener estadísticas geográficas
     */
    public function getGeographicStats(): JsonResponse
    {
        $stats = VisitorTracking::getGeographicStats();
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * API: Obtener estadísticas de dispositivos
     */
    public function getDeviceStats(): JsonResponse
    {
        $stats = VisitorTracking::getDeviceStats();
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * API: Trackear tiempo de visita en página actual
     */
    public function trackPageTime(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string',
            'page_url' => 'required|string',
            'time_spent' => 'required|integer|min:0',
            'page_title' => 'nullable|string'
        ]);

        try {
            $tracking = VisitorTracking::where('session_id', $request->session_id)
                ->where('page_url', $request->page_url)
                ->whereNull('visit_end')
                ->first();

            if ($tracking) {
                $tracking->update([
                    'visit_end' => now(),
                    'time_spent' => $request->time_spent,
                    'page_title' => $request->page_title
                ]);
            } else {
                // Crear nueva entrada si no existe
                VisitorTracking::create([
                    'session_id' => $request->session_id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'page_url' => $request->page_url,
                    'page_title' => $request->page_title,
                    'visit_start' => now()->subSeconds($request->time_spent),
                    'visit_end' => now(),
                    'time_spent' => $request->time_spent,
                    'device_type' => $this->parseUserAgent($request->userAgent())['device_type'],
                    'browser' => $this->parseUserAgent($request->userAgent())['browser']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tiempo de visita actualizado'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar tiempo de visita: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Obtener detalles de una sesión específica
     */
    public function getSessionDetails(Request $request, string $sessionId): JsonResponse
    {
        $visits = VisitorTracking::where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($visits->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesión no encontrada'
            ], 404);
        }

        $totalTime = $visits->sum('time_spent');
        $pageCount = $visits->count();

        return response()->json([
            'success' => true,
            'data' => [
                'session_id' => $sessionId,
                'visits' => $visits,
                'total_time' => $totalTime,
                'page_count' => $pageCount,
                'first_visit' => $visits->last()->created_at,
                'last_visit' => $visits->first()->created_at,
                'ip_address' => $visits->first()->ip_address,
                'user_agent' => $visits->first()->user_agent
            ]
        ]);
    }

    /**
     * API: Obtener estadísticas por IP
     */
    public function getStatsByIp(Request $request, string $ip): JsonResponse
    {
        $visits = VisitorTracking::byIp($ip)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'ip_address' => $ip,
            'total_visits' => $visits->count(),
            'unique_sessions' => $visits->pluck('session_id')->unique()->count(),
            'total_time' => $visits->sum('time_spent'),
            'first_visit' => $visits->last()?->created_at,
            'last_visit' => $visits->first()?->created_at,
            'pages_visited' => $visits->pluck('page_url')->unique()->values(),
            'visits' => $visits
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Parsear User Agent
     */
    private function parseUserAgent(string $userAgent): array
    {
        $deviceType = 'desktop';
        $browser = 'unknown';

        if (preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i', $userAgent)) {
            $deviceType = 'mobile';
        } elseif (preg_match('/Tablet|iPad/i', $userAgent)) {
            $deviceType = 'tablet';
        }

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
}
