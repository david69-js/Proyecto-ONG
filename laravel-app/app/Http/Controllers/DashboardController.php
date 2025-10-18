<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Beneficiary;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index()
    {
        // Obtener estadísticas básicas
        $stats = [
            'total_projects' => Project::count(),
            'total_beneficiaries' => Beneficiary::count(),
            'total_donations' => 0, // TODO: Implementar cuando se cree el modelo Donation
            'total_volunteers' => User::whereHas('roles', function($query) {
                $query->whereIn('slug', ['volunteer-staff', 'project-coordinator']);
            })->count(),
        ];

        // Obtener proyectos recientes (últimos 5)
        $recent_projects = Project::with('beneficiaries')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_projects'));
    }
}
