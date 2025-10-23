<?php
// routes/api.php
Route::post('/activity/heartbeat', [ActivityController::class, 'heartbeat']);

// app/Http/Controllers/ActivityController.php
public function heartbeat(Request $req)
{
    $data = $req->validate([
        'session_key' => 'required|string',
        'path' => 'required|string',
        'delta_seconds' => 'required|integer', // tiempo activo desde último heartbeat
        'visibility' => 'required|boolean',
    ]);

    $session = ActivitySession::firstOrCreate(
        ['session_key' => $data['session_key']],
        ['started_at' => now(), 'ip' => $req->ip(), 'user_agent' => $req->userAgent()]
    );

    // acumular tiempo solo si visible
    if ($data['visibility']) {
        $session->accumulated_seconds += $data['delta_seconds'];
        // actualizar page_times JSON
        $pageTimes = $session->page_times ?? [];
        $pageTimes[$data['path']] = ($pageTimes[$data['path']] ?? 0) + $data['delta_seconds'];
        $session->page_times = $pageTimes;
    }

    $session->current_path = $data['path'];
    $session->last_seen_at = now();
    $session->save();

    // opcional: broadcast para dashboard en tiempo real
    broadcast(new \App\Events\ActivityUpdated($session))->toOthers();

    return response()->json(['ok' => true]);
}
