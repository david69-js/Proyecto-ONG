<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Beneficiary;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ProjectReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reports.view')->only(['index', 'show']);
        $this->middleware('permission:reports.export')->only(['export']);
    }

    /**
     * Mostrar la página principal de reportes de proyectos
     */
    public function index(Request $request)
    {
        // Estadísticas generales
        $totalProjects = Project::count();
        $activeProjects = Project::where('estado', 'en_progreso')->count();
        $completedProjects = Project::where('estado', 'finalizado')->count();
        $plannedProjects = Project::where('estado', 'planificado')->count();

        // Estadísticas de presupuesto
        $totalBudget = Project::sum('presupuesto_total');
        $totalAssigned = Project::sum('fondos_asignados');
        $totalExecuted = Project::sum('fondos_ejecutados');

        // Proyectos por fase
        $projectsByPhase = Project::selectRaw('fase, COUNT(*) as count')
            ->groupBy('fase')
            ->get()
            ->keyBy('fase');

        // Proyectos por estado
        $projectsByStatus = Project::selectRaw('estado, COUNT(*) as count')
            ->groupBy('estado')
            ->get()
            ->keyBy('estado');

        // Proyectos recientes (últimos 6 meses)
        $recentProjects = Project::with(['responsable', 'beneficiaries'])
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Estadísticas de beneficiarios por proyecto
        $beneficiariesStats = Project::withCount('beneficiaries')
            ->orderBy('beneficiaries_count', 'desc')
            ->limit(5)
            ->get();

        // Filtros aplicados
        $filters = [
            'status' => $request->get('status'),
            'phase' => $request->get('phase'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        return view('reports.projects.index', compact(
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'plannedProjects',
            'totalBudget',
            'totalAssigned',
            'totalExecuted',
            'projectsByPhase',
            'projectsByStatus',
            'recentProjects',
            'beneficiariesStats',
            'filters'
        ));
    }

    /**
     * Mostrar reporte detallado de un proyecto específico
     */
    public function show(Project $project)
    {
        $project->load(['responsable', 'beneficiaries', 'phaseImages']);

        // Estadísticas del proyecto
        $beneficiariesCount = $project->beneficiaries->count();
        $donationsCount = Donation::where('project_id', $project->id)->count();
        $donationsAmount = Donation::where('project_id', $project->id)
            ->where('status', 'confirmed')
            ->sum('amount');

        // Progreso del proyecto
        $progress = $project->porcentaje ?? 0;
        $phaseInfo = $project->phase_info;

        // Fechas importantes
        $startDate = $project->fecha_inicio ? Carbon::parse($project->fecha_inicio) : null;
        $endDate = $project->fecha_fin ? Carbon::parse($project->fecha_fin) : null;
        $duration = null;
        
        if ($startDate && $endDate) {
            $duration = $startDate->diffInDays($endDate);
        }

        return view('reports.projects.show', compact(
            'project',
            'beneficiariesCount',
            'donationsCount',
            'donationsAmount',
            'progress',
            'phaseInfo',
            'startDate',
            'endDate',
            'duration'
        ));
    }

    /**
     * Exportar reporte de proyectos a PDF
     */
    public function export(Request $request)
    {
        $query = Project::with(['responsable', 'beneficiaries']);

        // Aplicar filtros
        if ($request->filled('status')) {
            $query->where('estado', $request->status);
        }
        if ($request->filled('phase')) {
            $query->where('fase', $request->phase);
        }
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', Carbon::parse($request->date_to)->endOfDay());
        }

        $projects = $query->orderBy('created_at', 'desc')->get();

        // Estadísticas generales
        $totalProjects = Project::count();
        $activeProjects = Project::where('estado', 'en_progreso')->count();
        $completedProjects = Project::where('estado', 'finalizado')->count();
        $totalBudget = Project::sum('presupuesto_total');
        $totalAssigned = Project::sum('fondos_asignados');
        $totalExecuted = Project::sum('fondos_ejecutados');

        // Generar PDF
        $pdf = Pdf::loadView('reports.projects.pdf', compact(
            'projects',
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'totalBudget',
            'totalAssigned',
            'totalExecuted'
        ));

        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'reporte_proyectos_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Exportar reporte detallado de un proyecto específico a PDF
     */
    public function exportProject(Project $project)
    {
        $project->load(['responsable', 'beneficiaries', 'phaseImages']);

        // Estadísticas del proyecto
        $beneficiariesCount = $project->beneficiaries->count();
        $donationsCount = Donation::where('project_id', $project->id)->count();
        $donationsAmount = Donation::where('project_id', $project->id)
            ->where('status', 'confirmed')
            ->sum('amount');

        // Progreso del proyecto
        $progress = $project->porcentaje ?? 0;
        $phaseInfo = $project->phase_info;

        // Fechas importantes
        $startDate = $project->fecha_inicio ? Carbon::parse($project->fecha_inicio) : null;
        $endDate = $project->fecha_fin ? Carbon::parse($project->fecha_fin) : null;
        $duration = null;
        
        if ($startDate && $endDate) {
            $duration = $startDate->diffInDays($endDate);
        }

        // Generar PDF
        $pdf = Pdf::loadView('reports.projects.pdf-detail', compact(
            'project',
            'beneficiariesCount',
            'donationsCount',
            'donationsAmount',
            'progress',
            'phaseInfo',
            'startDate',
            'endDate',
            'duration'
        ));

        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'reporte_proyecto_' . Str::slug($project->nombre) . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}
