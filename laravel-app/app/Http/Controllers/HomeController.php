<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Project;
use App\Models\Event;
use App\Models\BeneficiaryTestimonial;
use App\Models\SponsorHighlight;
use App\Models\DonorHighlight;

class HomeController extends Controller
{
    /**
     * Página principal (index original)
     */
    public function index()
    {
        $hero = HeroSection::first();
        $about = AboutSection::first();

        // ✅ Solo proyectos publicados
        $projects = Project::query()
            ->where('is_published', true)
               ->with('phaseImages')
            ->latest('created_at')
            ->take(12)
            ->get();

        // ✅ Testimonios publicados
        $testimonials = BeneficiaryTestimonial::with('beneficiary')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(50)
            ->get();

        // ✅ Patrocinadores publicados
        $sponsors = SponsorHighlight::with('sponsor')
            ->published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        // ✅ Donadores destacados publicados
        $donors = DonorHighlight::published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('index', compact(
            'hero',
            'about',
            'projects',
            'testimonials',
            'sponsors',
            'donors'
        ));
    }

    /**
     * Página alternativa (index2) con diseño UpConstruction
     */
    public function index2()
    {
        $hero = HeroSection::first();
        $about = AboutSection::first();

        // ✅ Solo proyectos publicados
        $projects = Project::query()
            ->where('is_published', true)
            ->latest('created_at')
            ->take(12)
            ->get();

        // ✅ Eventos públicos
        $events = Event::query()
            ->where('status', 'publicado')
            ->latest('start_date')
            ->take(6)
            ->get();

        // ✅ Testimonios publicados
        $testimonials = BeneficiaryTestimonial::with('beneficiary')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(20)
            ->get();

        // ✅ Patrocinadores publicados
        $sponsors = SponsorHighlight::with('sponsor')
            ->published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        // ✅ Donadores destacados
        $donors = DonorHighlight::published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('index2', compact(
            'hero',
            'about',
            'projects',
            'events',
            'testimonials',
            'sponsors',
            'donors'
        ));
    }
}
