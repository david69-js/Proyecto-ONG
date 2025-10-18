<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSectionController extends Controller
{
    /**
     * Mostrar el panel de administración de About.
     */
    public function index()
    {
        $about = AboutSection::first();

        // Si no existe, crear un registro inicial
        if (!$about) {
            $about = AboutSection::create([
                'titulo' => 'Construyendo esperanza desde 1995',
                'descripcion_principal' => 'Desde nuestros inicios hemos trabajado para que las familias guatemaltecas tengan acceso a una vivienda segura y un entorno digno.',
                'descripcion_secundaria' => 'Gracias al apoyo de donantes, voluntarios y aliados, hemos construido y mejorado cientos de hogares, transformando la vida de miles de personas.',
                'anios_servicio' => 25,
                'hogares_construidos' => 500,
                'compromiso_social' => 100,
                'colaboradores_activos' => 48,
                'imagen_principal' => 'assets/img/construction/project-3.webp',
                'imagen_secundaria' => 'assets/img/construction/project-7.webp',
                'badge_1' => 'assets/img/construction/badge-4.webp',
                'badge_2' => 'assets/img/construction/badge-3.webp',
                'badge_3' => 'assets/img/construction/badge-5.webp',
                'link_conoce_mas' => '#',
            ]);
        }

        return view('sections.about.index', compact('about'));
    }

    /**
     * Actualizar los datos de la sección About.
     */
    public function update(Request $request, $id)
    {
        $about = AboutSection::findOrFail($id);

        // Validar datos
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion_principal' => 'nullable|string',
            'descripcion_secundaria' => 'nullable|string',
            'anios_servicio' => 'nullable|numeric',
            'hogares_construidos' => 'nullable|numeric',
            'compromiso_social' => 'nullable|numeric',
            'colaboradores_activos' => 'nullable|numeric',
            'link_conoce_mas' => 'nullable|string',
            'imagen_principal' => 'nullable|image|max:2048',
            'imagen_secundaria' => 'nullable|image|max:2048',
            'imagen_extra' => 'nullable|image|max:2048',
            'badge_1' => 'nullable|image|max:2048',
            'badge_2' => 'nullable|image|max:2048',
            'badge_3' => 'nullable|image|max:2048',
        ]);

        // Actualizar campos de texto y logros numéricos
        $about->update($request->only([
            'titulo',
            'descripcion_principal',
            'descripcion_secundaria',
            'anios_servicio',
            'hogares_construidos',
            'compromiso_social',
            'colaboradores_activos',
            'link_conoce_mas',
        ]));

        // Manejo de imágenes generales y badges
        $imagenes = array_merge(
            ['imagen_principal', 'imagen_secundaria', 'imagen_extra'],
            ['badge_1', 'badge_2', 'badge_3']
        );

        foreach ($imagenes as $img) {
            if ($request->hasFile($img)) {
                // Eliminar imagen antigua si existe y no es la de assets inicial
                if ($about->$img && !str_starts_with($about->$img, 'assets/')) {
                    Storage::disk('public')->delete($about->$img);
                }

                // Guardar nueva imagen
                $path = $request->file($img)->store('about', 'public');
                $about->$img = $path;
            }
        }

        $about->save();

        return redirect()->route('admin.about.index')
                         ->with('success', 'Datos actualizados correctamente.');
    }
}
