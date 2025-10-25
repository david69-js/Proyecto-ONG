<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectPhaseImage;
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
            'fase' => 'required|in:diagnostico,formulacion,financiacion,ejecucion,evaluacion,cierre',
            'phase_images_data.*.phase' => 'nullable|in:diagnostico,formulacion,financiacion,ejecucion,evaluacion,cierre',
            'phase_images_data.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'phase_images_data.*.descriptions.*' => 'nullable|string|max:500',
        ]);

        $project = Project::create($validated);

        // Manejar imágenes por fase
        if ($request->has('phase_images_data')) {
            $this->handlePhaseImagesUpload($request, $project);
        }

        return redirect()->route('projects.index')
                         ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Project $project)
    {
        // Verificar autorización
        $this->authorize('view', $project);

        $project->load('phaseImages');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        // Verificar autorización
        $this->authorize('update', $project);

        $usuarios = User::all();
        $project->load('phaseImages');
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
            'fase' => 'sometimes|required|in:diagnostico,formulacion,financiacion,ejecucion,evaluacion,cierre',
            'phase_images_data.*.phase' => 'nullable|in:diagnostico,formulacion,financiacion,ejecucion,evaluacion,cierre',
            'phase_images_data.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'phase_images_data.*.descriptions.*' => 'nullable|string|max:500',
        ]);

        $project->update($validated);

        // Manejar imágenes por fase
        if ($request->has('phase_images_data')) {
            $this->handlePhaseImagesUpload($request, $project);
        }

        return redirect()->route('projects.index')
                         ->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project)
    {
        // Verificar autorización
        $this->authorize('delete', $project);

        // Eliminar imágenes de fase
        foreach ($project->phaseImages as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $project->delete();
        return redirect()->route('projects.index')
                         ->with('success', 'Proyecto eliminado correctamente.');
    }

    /**
     * Eliminar imagen por fase
     */
    public function deletePhaseImage(ProjectPhaseImage $image)
    {
        // Verificar autorización
        $this->authorize('update', $image->project);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Imagen eliminada correctamente'
        ]);
    }

    /**
     * Manejar carga de imágenes por fase
     */
    private function handlePhaseImagesUpload(Request $request, Project $project)
    {
        $phaseImagesData = $request->input('phase_images_data', []);

        foreach ($phaseImagesData as $index => $phaseData) {
            $phase = $phaseData['phase'] ?? null;
            $images = $request->file("phase_images_data.{$index}.images", []);
            $descriptions = $phaseData['descriptions'] ?? [];

            if ($phase && $images) {
                foreach ($images as $imageIndex => $image) {
                    if ($image) {
                        $path = $image->store('projects/phase-images', 'public');
                        
                        ProjectPhaseImage::create([
                            'project_id' => $project->id,
                            'fase' => $phase,
                            'image_path' => $path,
                            'original_name' => $image->getClientOriginalName(),
                            'mime_type' => $image->getMimeType(),
                            'file_size' => $image->getSize(),
                            'description' => $descriptions[$imageIndex] ?? null,
                        ]);
                    }
                }
            }
        }
    }

    /**
     *Publicar o despublicar proyecto
     */
public function togglePublish(Project $project)
{
    // Cambiar el estado actual
    $project->is_published = !$project->is_published;
    $project->save();

    // Mensaje según la acción
    $message = $project->is_published
        ? 'El proyecto ha sido publicado correctamente y ahora es visible en el sitio público.'
        : 'El proyecto ha sido despublicado y ya no aparecerá en el sitio público.';

    return redirect()->back()->with('success', $message);
}
public function publicShow2(Project $project)
{
    // 🔹 Cargar relaciones si es necesario
    $project->load(['responsable', 'phaseImages']);

    return view('projects.public-show2', compact('project'));
}

}
