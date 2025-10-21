<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectPhaseImage;
use App\Models\User;
use App\Policies\ProjectPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
            'fase_actual' => 'in:diagnostico,formulacion,financiacion,ejecucion,evaluacion,cierre',
            'porcentaje_diagnostico' => 'nullable|integer|min:0|max:100',
            'porcentaje_formulacion' => 'nullable|integer|min:0|max:100',
            'porcentaje_financiacion' => 'nullable|integer|min:0|max:100',
            'porcentaje_ejecucion' => 'nullable|integer|min:0|max:100',
            'porcentaje_evaluacion' => 'nullable|integer|min:0|max:100',
            'porcentaje_cierre' => 'nullable|integer|min:0|max:100',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')
                         ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Project $project)
    {
        // Verificar autorización
        $this->authorize('view', $project);

        // Cargar las imágenes de las fases
        $project->load('phaseImages');

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
            'fase_actual' => 'in:diagnostico,formulacion,financiacion,ejecucion,evaluacion,cierre',
            'porcentaje_diagnostico' => 'nullable|integer|min:0|max:100',
            'porcentaje_formulacion' => 'nullable|integer|min:0|max:100',
            'porcentaje_financiacion' => 'nullable|integer|min:0|max:100',
            'porcentaje_ejecucion' => 'nullable|integer|min:0|max:100',
            'porcentaje_evaluacion' => 'nullable|integer|min:0|max:100',
            'porcentaje_cierre' => 'nullable|integer|min:0|max:100',
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


    /**
     * Update project phase percentages.
     */
    public function updatePhases(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'fase_actual' => 'required|in:diagnostico,formulacion,financiacion,ejecucion,evaluacion,cierre',
            'porcentaje_diagnostico' => 'required|integer|min:0|max:100',
            'porcentaje_formulacion' => 'required|integer|min:0|max:100',
            'porcentaje_financiacion' => 'required|integer|min:0|max:100',
            'porcentaje_ejecucion' => 'required|integer|min:0|max:100',
            'porcentaje_evaluacion' => 'required|integer|min:0|max:100',
            'porcentaje_cierre' => 'required|integer|min:0|max:100',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Fases del proyecto actualizadas correctamente.');
    }

    /**
     * Upload image for a project phase.
     */
    public function uploadPhaseImage(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'fase' => 'required|in:diagnostico,formulacion,financiacion,ejecucion,evaluacion,cierre',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // Store the image
        $imagePath = $request->file('imagen')->store('project-phases', 'public');

        // Create the phase image record
        ProjectPhaseImage::create([
            'project_id' => $project->id,
            'fase' => $validated['fase'],
            'imagen_path' => $imagePath,
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'orden' => $project->phaseImages()->where('fase', $validated['fase'])->count() + 1
        ]);

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Imagen subida correctamente.');
    }

    /**
     * Delete a project phase image.
     */
    public function deletePhaseImage(ProjectPhaseImage $phaseImage)
    {
        $this->authorize('update', $phaseImage->project);

        // Delete the file from storage
        Storage::disk('public')->delete($phaseImage->imagen_path);

        // Delete the record
        $phaseImage->delete();

        return redirect()->route('projects.show', $phaseImage->project)
                         ->with('success', 'Imagen eliminada correctamente.');
    }
}