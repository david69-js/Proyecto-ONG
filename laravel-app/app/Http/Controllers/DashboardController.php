<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Beneficiary;
use App\Models\Donation;
use App\Models\Product;
use App\Models\Event;
use App\Models\Sponsor;
use App\Models\Location;
use App\Models\VisitorTracking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'total_beneficiaries' => Beneficiary::count(),
            'total_donations' => Donation::count(),
            'total_products' => Product::count(),
            'total_events' => Event::count(),
            'total_sponsors' => Sponsor::count(),
            'total_locations' => Location::count(),
        ];

        // Proyectos activos
        $stats['active_projects'] = Project::where('estado', 'en_progreso')->count();
        $stats['completed_projects'] = Project::where('estado', 'finalizado')->count();

        // Beneficiarios activos
        $stats['active_beneficiaries'] = Beneficiary::where('is_active', true)->count();
        
        // Beneficiarios por género
        $stats['male_beneficiaries'] = Beneficiary::where('gender', 'male')->count();
        $stats['female_beneficiaries'] = Beneficiary::where('gender', 'female')->count();
        
        // Beneficiarios por edad
        $stats['child_beneficiaries'] = Beneficiary::where('age', '<', 18)->count();
        $stats['adult_beneficiaries'] = Beneficiary::where('age', '>=', 18)->count();

        // Donaciones del mes actual
        $stats['donations_this_month'] = Donation::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Monto total de donaciones
        $stats['total_donation_amount'] = Donation::where('status', 'confirmed')->sum('amount');

        // Monto de donaciones del mes
        $stats['donation_amount_this_month'] = Donation::where('status', 'confirmed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        // Productos disponibles
        $stats['available_products'] = Product::where('is_active', true)->count();

        // Eventos próximos
        $stats['upcoming_events'] = Event::where('start_date', '>=', Carbon::now())->count();
        
        // Patrocinadores activos
        $stats['active_sponsors'] = Sponsor::where('status', 'active')->count();
        
        // Donaciones confirmadas
        $stats['confirmed_donations'] = Donation::where('status', 'confirmed')->count();
        
        // Donaciones pendientes
        $stats['pending_donations'] = Donation::where('status', 'pending')->count();

        // Proyectos recientes (últimos 5)
        $recent_projects = Project::with(['beneficiaries'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($project) {
                $project->beneficiaries_count = $project->beneficiaries->count();
                return $project;
            });

        // Donaciones recientes (últimas 5)
        $recent_donations = Donation::with(['user', 'project'])
            ->latest()
            ->take(5)
            ->get();

        // Usuarios recientes (últimos 5)
        $recent_users = User::with(['roles'])
            ->latest()
            ->take(5)
            ->get();
            
        // Beneficiarios recientes (últimos 5)
        $recent_beneficiaries = Beneficiary::with(['user'])
            ->latest()
            ->take(5)
            ->get();

        // Estadísticas por mes (últimos 6 meses)
        $monthly_stats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthly_stats[] = [
                'month' => $date->format('M Y'),
                'donations' => Donation::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
                'projects' => Project::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
                'users' => User::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
            ];
        }

        // Proyectos por estado
        $projects_by_status = Project::selectRaw('estado, COUNT(*) as count')
            ->groupBy('estado')
            ->get()
            ->pluck('count', 'estado');

        // Donaciones por estado
        $donations_by_status = Donation::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Usuarios por rol
        $users_by_role = User::with('roles')
            ->get()
            ->flatMap(function($user) {
                return $user->roles->pluck('name');
            })
            ->countBy();

        // Estadísticas de Visitor Tracking
        $visitor_stats = [
            'total_visitors_today' => VisitorTracking::whereDate('created_at', Carbon::today())->distinct('session_id')->count(),
            'total_visitors_week' => VisitorTracking::where('created_at', '>=', Carbon::now()->subDays(7))->distinct('session_id')->count(),
            'total_page_views_today' => VisitorTracking::whereDate('created_at', Carbon::today())->count(),
            'active_visitors_now' => VisitorTracking::getActiveVisitors(5)->count(),
            'top_pages_today' => VisitorTracking::getTopPages(5),
            'visitor_stats_week' => VisitorTracking::getVisitorStats(7),
            'device_stats' => VisitorTracking::getDeviceStats(),
        ];

        return view('dashboard', compact(
            'stats',
            'recent_projects',
            'recent_donations',
            'recent_users',
            'recent_beneficiaries',
            'monthly_stats',
            'projects_by_status',
            'donations_by_status',
            'users_by_role',
            'visitor_stats'
        ));
    }
}