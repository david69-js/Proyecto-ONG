<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    // Muestra una sola página de admin con el formulario (si hay registro, lo edita; si no, lo crea)
    public function index()
    {
        $hero = HeroSection::first();
        return view('sections.hero.index', compact('hero')); // vista admin
    }

    // Crear (si aún no hay Hero)
    public function store(Request $request)
    {
        $data = $request->validate([
            'subtitle'               => 'nullable|string|max:255',
            'title'                  => 'nullable|string|max:255',
            'description'            => 'nullable|string',
            'button_primary_text'    => 'nullable|string|max:255',
            'button_primary_link'    => 'nullable|string|max:255',
            'button_secondary_text'  => 'nullable|string|max:255',
            'button_secondary_link'  => 'nullable|string|max:255',
            'anios_servicio'         => 'nullable|integer',
            'viviendas_construidas'  => 'nullable|integer',
            'familias_beneficiadas'  => 'nullable|integer',
            'image_badge_text'       => 'nullable|string|max:255',
            'image_badge_subtext'    => 'nullable|string|max:255',
            'image_main'             => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image_main')) {
            $data['image_main'] = $request->file('image_main')->store('hero_images', 'public');
        }

        // para garantizar un solo registro
        $existing = HeroSection::first();
        if ($existing) {
            $existing->update($data);
            return redirect()->route('admin.hero.index')->with('success', 'Sección Hero actualizada.');
        }

        HeroSection::create($data);
        return redirect()->route('admin.hero.index')->with('success', 'Sección Hero creada.');
    }

    // Actualizar (si ya existe)
    public function update(Request $request, $id)
    {
        $hero = HeroSection::findOrFail($id);

        $data = $request->validate([
            'subtitle'               => 'nullable|string|max:255',
            'title'                  => 'nullable|string|max:255',
            'description'            => 'nullable|string',
            'button_primary_text'    => 'nullable|string|max:255',
            'button_primary_link'    => 'nullable|string|max:255',
            'button_secondary_text'  => 'nullable|string|max:255',
            'button_secondary_link'  => 'nullable|string|max:255',
            'anios_servicio'         => 'nullable|integer',
            'viviendas_construidas'  => 'nullable|integer',
            'familias_beneficiadas'  => 'nullable|integer',
            'image_badge_text'       => 'nullable|string|max:255',
            'image_badge_subtext'    => 'nullable|string|max:255',
            'image_main'             => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image_main')) {
            if ($hero->image_main) {
                Storage::disk('public')->delete($hero->image_main);
            }
            $data['image_main'] = $request->file('image_main')->store('hero_images', 'public');
        }

        $hero->update($data);
        return back()->with('success', 'Sección Hero actualizada.');
    }
}
