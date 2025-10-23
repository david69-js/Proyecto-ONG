<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorTrackingController;

// Rutas API para Visitor Tracking
Route::prefix('visitor-tracking')->group(function () {
    // Estadísticas generales
    Route::get('/stats', [VisitorTrackingController::class, 'getStats']);
    Route::get('/active-visitors', [VisitorTrackingController::class, 'getActiveVisitors']);
    Route::get('/top-pages', [VisitorTrackingController::class, 'getTopPages']);
    Route::get('/geographic-stats', [VisitorTrackingController::class, 'getGeographicStats']);
    Route::get('/device-stats', [VisitorTrackingController::class, 'getDeviceStats']);
    
    // Tracking de tiempo de página
    Route::post('/track-page-time', [VisitorTrackingController::class, 'trackPageTime']);
    
    // Detalles específicos
    Route::get('/session/{sessionId}', [VisitorTrackingController::class, 'getSessionDetails']);
    Route::get('/ip/{ip}', [VisitorTrackingController::class, 'getStatsByIp']);
});

// Rutas existentes de actividad
