<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroSectionController extends Controller
{
    /**
     * Mostrar la vista única de edición de la sección Hero.
     */
    public function index()
    {
        // Si no existe un registro, creamos uno vacío
        $hero = HeroSection::first() ?? HeroSection::create([]);

        return view('sections.hero.index', compact('hero'));
    }

    /**
     * Actualizar la información del Hero.
     */
    public function update(Request $request, HeroSection $hero)
    {
        $validated = $request->validate([
            'subtitle'               => ['nullable', 'string', 'max:255'],
            'title'                  => ['nullable', 'string', 'max:255'],
            'description'            => ['nullable', 'string'],
            'button_primary_text'    => ['nullable', 'string', 'max:100'],
            'button_primary_link'    => ['nullable', 'string', 'max:255'],
            'button_secondary_text'  => ['nullable', 'string', 'max:100'],
            'button_secondary_link'  => ['nullable', 'string', 'max:255'],
            'anios_servicio'         => ['nullable', 'integer', 'min:0'],
            'viviendas_construidas'  => ['nullable', 'integer', 'min:0'],
            'familias_beneficiadas'  => ['nullable', 'integer', 'min:0'],
            'image_main'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_badge_text'       => ['nullable', 'string', 'max:255'],
            'image_badge_subtext'    => ['nullable', 'string', 'max:255'],
        ]);

        $data = $validated;

        if ($request->hasFile('image_main')) {

            // Eliminar la anterior si existe
            if ($hero->image_main && Storage::disk('public')->exists($hero->image_main)) {
                Storage::disk('public')->delete($hero->image_main);
            }

            // Guardar nueva
            $filename = Str::slug($request->title ?: 'hero') . '_' . time() . '.' .
                $request->file('image_main')->extension();

            $data['image_main'] = $request->file('image_main')->storeAs('hero', $filename, 'public');
        }

        $hero->update($data);

        cache()->forget('home:hero');

        return back()->with('success', ' Sección Hero actualizada correctamente.');
    }
}
