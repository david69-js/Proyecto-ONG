<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Policies\ProjectPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function index()
    {
        // Verificar autorización
        $this->authorize('viewAny', Project::class);

        // Obtener proyectos según el rol del usuario
        $query = Project::with('responsable');
        $projects = ProjectPolicy::scopeForUser(auth()->user(), $query)->get();

        return view('projects.index', compact('projects'));
    }
    

    public function create()
    {
        // Verificar autorización
        $this->authorize('create', Project::class);

        $usuarios = User::all(); 
        return view('projects.create', [
            'project' => new Project(), 
            'usuarios' => $usuarios
        ]);
    }

    public function store(Request $request)
    {
        // Verificar autorización
        $this->authorize('create', Project::class);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'objetivo' => 'nullable|string',
            'beneficiarios' => 'nullable|string',
            'presupuesto_total' => 'nullable|numeric',
            'fondos_asignados' => 'nullable|numeric',
            'fondos_ejecutados' => 'nullable|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'in:planificado,en_progreso,pausado,finalizado,cancelado',
            'responsable_id' => 'nullable|exists:sys_users,id', 
            'resultados_esperados' => 'nullable|string',
            'resultados_obtenidos' => 'nullable|string',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')
                         ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Project $project)
    {
        // Verificar autorización
        $this->authorize('view', $project);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        // Verificar autorización
        $this->authorize('update', $project);

        $usuarios = User::all();
        return view('projects.edit', [
            'project' => $project,
            'usuarios' => $usuarios
        ]);
    }


    public function update(Request $request, Project $project)
    {
        // Verificar autorización
        $this->authorize('update', $project);

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'objetivo' => 'nullable|string',
            'beneficiarios' => 'nullable|string',
            'presupuesto_total' => 'nullable|numeric',
            'fondos_asignados' => 'nullable|numeric',
            'fondos_ejecutados' => 'nullable|numeric',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'in:planificado,en_progreso,pausado,finalizado,cancelado',
            'responsable_id' => 'nullable|exists:sys_users,id',
            'ubicacion' => 'nullable|string',
            'resultados_esperados' => 'nullable|string',
            'resultados_obtenidos' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
                         ->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project)
    {
        // Verificar autorización
        $this->authorize('delete', $project);

        $project->delete();
        return redirect()->route('projects.index')
                         ->with('success', 'Proyecto eliminado correctamente.');
    }
}