<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Project;
use App\Models\BeneficiaryTestimonial;
use App\Models\SponsorHighlight;
use App\Models\DonorHighlight;

class HomeController extends Controller
{
    public function index()
    {
        $hero = HeroSection::first();
        $about = AboutSection::first();

        $projects = Project::query()
            ->where('show_in_index', true)
            ->latest('created_at')
            ->take(12)
            ->get();

        // Trae SOLO los publicados, sin caché
        $testimonials = BeneficiaryTestimonial::with('beneficiary')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(50) // o el número que quieras
            ->get();
            
 // Trae SOLO los publicados, sin caché
            $sponsors = SponsorHighlight::with('sponsor')
    ->published()
    ->orderBy('is_featured','desc')
    ->orderBy('sort_order')
    ->get();

    $donors = DonorHighlight::published()
    ->orderBy('is_featured','desc')
    ->orderBy('sort_order')
    ->orderByDesc('id')
    ->get();

        return view('index', compact('hero', 'about', 'projects', 'testimonials', 'sponsors', 'donors'));
    }


}
