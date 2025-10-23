<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VisitorTracking extends Model
{
    use HasFactory;

    protected $table = 'visitor_tracking';

    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'page_url',
        'page_title',
        'referrer',
        'visit_start',
        'visit_end',
        'time_spent',
        'page_data',
        'country',
        'city',
        'device_type',
        'browser'
    ];

    protected $casts = [
        'visit_start' => 'datetime',
        'visit_end' => 'datetime',
        'page_data' => 'array',
        'time_spent' => 'integer'
    ];

    /**
     * Obtener estadísticas de visitantes por período
     */
    public static function getVisitorStats($days = 7)
    {
        $startDate = Carbon::now()->subDays($days);
        
        return self::where('created_at', '>=', $startDate)
            ->selectRaw('
                COUNT(DISTINCT session_id) as unique_visitors,
                COUNT(DISTINCT ip_address) as unique_ips,
                COUNT(*) as total_page_views,
                AVG(time_spent) as avg_time_spent,
                DATE(created_at) as date
            ')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Obtener páginas más visitadas
     */
    public static function getTopPages($limit = 10)
    {
        return self::selectRaw('
                page_url,
                page_title,
                COUNT(*) as visits,
                AVG(time_spent) as avg_time_spent,
                COUNT(DISTINCT session_id) as unique_visitors
            ')
            ->groupBy('page_url', 'page_title')
            ->orderBy('visits', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtener visitantes activos en tiempo real
     */
    public static function getActiveVisitors($minutes = 5)
    {
        $cutoff = Carbon::now()->subMinutes($minutes);
        
        return self::where('visit_end', '>=', $cutoff)
            ->orWhere(function($query) use ($cutoff) {
                $query->whereNull('visit_end')
                      ->where('visit_start', '>=', $cutoff);
            })
            ->get()
            ->groupBy('session_id');
    }

    /**
     * Obtener información geográfica de visitantes
     */
    public static function getGeographicStats()
    {
        return self::selectRaw('
                country,
                city,
                COUNT(DISTINCT session_id) as visitors,
                COUNT(*) as page_views
            ')
            ->whereNotNull('country')
            ->groupBy('country', 'city')
            ->orderBy('visitors', 'desc')
            ->get();
    }

    /**
     * Obtener estadísticas de dispositivos
     */
    public static function getDeviceStats()
    {
        return self::selectRaw('
                device_type,
                browser,
                COUNT(DISTINCT session_id) as visitors,
                COUNT(*) as page_views
            ')
            ->groupBy('device_type', 'browser')
            ->orderBy('visitors', 'desc')
            ->get();
    }

    /**
     * Scope para filtrar por IP
     */
    public function scopeByIp($query, $ip)
    {
        return $query->where('ip_address', $ip);
    }

    /**
     * Scope para filtrar por sesión
     */
    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope para filtrar por período
     */
    public function scopeInPeriod($query, $startDate, $endDate = null)
    {
        $query->where('created_at', '>=', $startDate);
        
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }
        
        return $query;
    }

    /**
     * Formatear tiempo de visita
     */
    public function getFormattedTimeSpentAttribute()
    {
        $seconds = $this->time_spent;
        
        if ($seconds < 60) {
            return $seconds . ' seg';
        } elseif ($seconds < 3600) {
            return floor($seconds / 60) . ' min ' . ($seconds % 60) . ' seg';
        } else {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            return $hours . 'h ' . $minutes . 'm';
        }
    }
}
