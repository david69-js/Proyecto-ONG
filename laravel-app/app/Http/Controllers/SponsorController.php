<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sponsor::query();

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo de patrocinador
        if ($request->filled('sponsor_type')) {
            $query->where('sponsor_type', $request->sponsor_type);
        }

        // Filtro por tipo de contribución
        if ($request->filled('contribution_type')) {
            $query->where('contribution_type', $request->contribution_type);
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por destacados
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'priority_level');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['name', 'company_name', 'contribution_amount', 'priority_level', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $sponsors = $query->paginate(15)->withQueryString();

        return view('sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
<<<<<<< HEAD
        $projects = Project::where('estado', '!=', 'finalizado')->get();
=======
        $projects = Project::where('estado', '!=', 'completado')->get();
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
        return view('sponsors.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'required|email|unique:ng_sponsors,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'sponsor_type' => 'required|in:individual,corporate,foundation,ngo,government,international',
            'contribution_type' => 'required|in:monetary,materials,services,volunteer,mixed',
            'contribution_amount' => 'nullable|numeric|min:0',
            'contribution_description' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending,suspended',
            'partnership_start_date' => 'nullable|date',
            'partnership_end_date' => 'nullable|date|after_or_equal:partnership_start_date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'priority_level' => 'required|integer|min:1|max:10',
            'projects' => 'nullable|array',
<<<<<<< HEAD
            'projects.*' => 'exists:ng_projects,id',
=======
            'projects.*' => 'exists:projects,id',
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
        ]);

        // Defaults
        $validated['is_featured'] = (bool) $request->boolean('is_featured');

        try {
            // Manejar subida de logo
            if ($request->hasFile('logo')) {
                $validated['logo_path'] = $request->file('logo')->store('sponsors/logos', 'public');
            }

            // Crear el patrocinador (excluir campos no persistentes)
            $sponsor = Sponsor::create(collect($validated)->except(['projects'])->toArray());

            // Asociar proyectos si se proporcionaron
            if ($request->filled('projects')) {
                $projectsData = [];
                foreach ($request->projects as $projectId) {
                    $projectsData[$projectId] = [
                        'contribution_amount' => $request->get("project_amount_{$projectId}"),
                        'contribution_type' => $request->get("project_contribution_type_{$projectId}"),
                        'sponsorship_date' => now(),
                    ];
                }
                $sponsor->projects()->attach($projectsData);
            }

            return redirect()->route('sponsors.index')
                            ->with('success', 'Patrocinador creado exitosamente.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'No se pudo guardar el patrocinador. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        $sponsor->load(['projects']);
        return view('sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
<<<<<<< HEAD
        $projects = Project::where('estado', '!=', 'finalizado')->get();
=======
        $projects = Project::where('estado', '!=', 'completado')->get();
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
        $sponsor->load('projects');
        return view('sponsors.edit', compact('sponsor', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => ['required', 'email', Rule::unique('ng_sponsors')->ignore($sponsor->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'sponsor_type' => 'required|in:individual,corporate,foundation,ngo,government,international',
            'contribution_type' => 'required|in:monetary,materials,services,volunteer,mixed',
            'contribution_amount' => 'nullable|numeric|min:0',
            'contribution_description' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending,suspended',
            'partnership_start_date' => 'nullable|date',
            'partnership_end_date' => 'nullable|date|after_or_equal:partnership_start_date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'priority_level' => 'required|integer|min:1|max:10',
            'projects' => 'nullable|array',
<<<<<<< HEAD
            'projects.*' => 'exists:ng_projects,id',
=======
            'projects.*' => 'exists:projects,id',
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
        ]);

        // Defaults
        $validated['is_featured'] = (bool) $request->boolean('is_featured');

        try {
            // Manejar subida de logo
            if ($request->hasFile('logo')) {
                // Eliminar logo anterior si existe
                if ($sponsor->logo_path) {
                    Storage::disk('public')->delete($sponsor->logo_path);
                }
                $validated['logo_path'] = $request->file('logo')->store('sponsors/logos', 'public');
            }

            // Actualizar el patrocinador (excluir campos no persistentes)
            $sponsor->update(collect($validated)->except(['projects'])->toArray());

            // Actualizar proyectos asociados
            if ($request->has('projects')) {
                $projectsData = [];
                foreach ($request->projects as $projectId) {
                    $projectsData[$projectId] = [
                        'contribution_amount' => $request->get("project_amount_{$projectId}"),
                        'contribution_type' => $request->get("project_contribution_type_{$projectId}"),
                        'sponsorship_date' => now(),
                    ];
                }
                $sponsor->projects()->sync($projectsData);
            } else {
                $sponsor->projects()->detach();
            }

            return redirect()->route('sponsors.index')
                            ->with('success', 'Patrocinador actualizado exitosamente.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'No se pudo actualizar el patrocinador. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        // Eliminar logo si existe
        if ($sponsor->logo_path) {
            Storage::disk('public')->delete($sponsor->logo_path);
        }

        $sponsor->delete();

        return redirect()->route('sponsors.index')
                        ->with('success', 'Patrocinador eliminado exitosamente.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Sponsor $sponsor)
    {
        $sponsor->update(['is_featured' => !$sponsor->is_featured]);

        $status = $sponsor->is_featured ? 'destacado' : 'no destacado';
        
        return redirect()->back()
                        ->with('success', "Patrocinador marcado como {$status}.");
    }

    /**
     * Toggle status
     */
    public function toggleStatus(Sponsor $sponsor)
    {
        $newStatus = $sponsor->status === 'active' ? 'inactive' : 'active';
        $sponsor->update(['status' => $newStatus]);

        $statusText = $newStatus === 'active' ? 'activado' : 'desactivado';
        
        return redirect()->back()
                        ->with('success', "Patrocinador {$statusText} exitosamente.");
    }
}
