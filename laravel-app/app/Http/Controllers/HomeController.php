<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        // Sección Hero y About
        $hero = HeroSection::first();
        $about = AboutSection::first();

        // SOLO proyectos publicados desde el panel admin
        $projects = Project::where('show_in_index', true)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Pasamos todo a la vista principal
        return view('index', compact('hero', 'about', 'projects'));
    }
}
