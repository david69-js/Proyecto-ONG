<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Project;

class ProjectIndexController extends Controller
{
    /**
     * Vista pública (home page)
     */
    public function indexPublic()
    {
        $hero = HeroSection::first();
        $about = AboutSection::first();

        // Solo proyectos publicados
        $projects = Project::where('show_in_index', true)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Vista principal pública
        return view('index', compact('hero', 'about', 'projects'));
    }

    /**
     * Panel administrativo de proyectos
     */
    public function indexAdmin()
    {
        // Todos los proyectos sin filtrar
        $projects = Project::orderBy('created_at', 'desc')->get();

        return view('sections.projects.index', compact('projects'));
    }

    /**
     * Publicar / Despublicar un proyecto
     */
    public function toggle(Project $project)
    {
        $project->show_in_index = !$project->show_in_index;
        $project->save();

        return redirect()->back()->with('success', "El proyecto '{$project->nombre}' ha sido " . ($project->show_in_index ? 'publicado' : 'despublicado') . " correctamente.");
    }

    /**
     * Eliminar un proyecto
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', "El proyecto '{$project->nombre}' ha sido eliminado correctamente.");
    }

    /**
     * Mostrar detalles de un proyecto (opcional)
     */
    public function show(Project $project)
    {
        return view('sections.projects.show', compact('project'));
    }
}
