<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    // Mostrar Hero en index
    public function index()
    {
        $hero = HeroSection::first();
        return view('sections.hero.index', compact('hero'));
    }

    // Mostrar formulario para editar Hero
    public function edit($id)
    {
        $hero = HeroSection::findOrFail($id);
        return view('hero.edit', compact('hero'));
    }

    // Actualizar Hero
    public function update(Request $request, $id)
    {
        $hero = HeroSection::findOrFail($id);

        $data = $request->only([
            'subtitle', 'title', 'description',
            'button_primary_text', 'button_primary_link',
            'button_secondary_text', 'button_secondary_link',
            'anios_servicio', 'viviendas_construidas', 'familias_beneficiadas',
            'image_badge_text', 'image_badge_subtext'
        ]);

        // Imagen principal
        if ($request->hasFile('image_main')) {
            if ($hero->image_main) {
                Storage::delete($hero->image_main);
            }
            $data['image_main'] = $request->file('image_main')->store('hero_images');
        }

        $hero->update($data);

        return redirect()->back()->with('success', 'Sección Hero actualizada correctamente.');
    }
}
