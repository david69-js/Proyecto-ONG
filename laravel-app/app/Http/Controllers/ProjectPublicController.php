<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectPublicController extends Controller
{
    /**
     * Muestra la página pública de un proyecto.
     */
    public function show(Project $project)
    {
        // Solo mostrar si está publicado
        if (!$project->is_published) {
            abort(404);
        }

        // Cargar imágenes de fases y responsable
        $project->load(['phaseImages', 'responsable']);

        return view('projects.public-show', compact('project'));
    }
}
