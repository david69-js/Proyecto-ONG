<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroSectionController extends Controller
{
    // GET /admin/hero  -> muestra la vista única con el formulario
    public function index()
    {
        // Trae el único registro (o lo crea vacío si no existe)
        $hero = HeroSection::first();
        if (!$hero) {
            $hero = HeroSection::create([]); // asegura que exista un ID para el form
        }

        // Tu vista de edición única:
        // resources/views/sections/hero/index.blade.php
        return view('sections.hero.index', compact('hero'));
    }

    // PUT /admin/hero/{hero} -> guarda cambios (incluye imagen)
    public function update(Request $request, HeroSection $hero)
    {
        $request->validate([
            'subtitle'               => ['nullable','string','max:255'],
            'title'                  => ['nullable','string','max:255'],
            'description'            => ['nullable','string'],
            'button_primary_text'    => ['nullable','string','max:100'],
            'button_primary_link'    => ['nullable','string','max:255'],
            'button_secondary_text'  => ['nullable','string','max:100'],
            'button_secondary_link'  => ['nullable','string','max:255'],
            'anios_servicio'         => ['nullable','integer','min:0'],
            'viviendas_construidas'  => ['nullable','integer','min:0'],
            'familias_beneficiadas'  => ['nullable','integer','min:0'],
            'image_main'             => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'image_badge_text'       => ['nullable','string','max:255'],
            'image_badge_subtext'    => ['nullable','string','max:255'],
        ]);

        $data = $request->except('image_main');

        if ($request->hasFile('image_main')) {
            if ($hero->image_main) {
                Storage::disk('public')->delete($hero->image_main);
            }
            $filename = Str::slug($request->title ?: 'hero') . '_' . time() . '.' . $request->file('image_main')->extension();
            $data['image_main'] = $request->file('image_main')->storeAs('hero', $filename, 'public');
        }

        $hero->update($data);

        // Si cacheas el home, invalida
        cache()->forget('home:hero');

        return back()->with('success', 'Sección Hero actualizada correctamente.');
    }
}
