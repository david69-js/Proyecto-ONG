<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Mostrar listado
    public function index()
    { 
        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }

    // Mostrar formulario crear
    public function create()
    {
        return view('locations.create');
    }

    // Guardar nueva ubicación
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'pais' => 'nullable|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        Location::create($request->all());

        // ✅ Regresa al formulario de creación, no al index
        return redirect()->route('locations.create')->with('success', 'Ubicación creada correctamente');
    }


    // Mostrar un registro
    public function show(Location $location)
    {
        return view('locations.show', compact('locations'));
    }

    // Mostrar formulario editar
    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    // Actualizar registro
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'pais' => 'nullable|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        $location->update($request->all());

        return redirect()->route('locations.index')->with('success', 'Ubicación actualizada correctamente');
    }

    // Eliminar registro
    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Ubicación eliminada correctamente');
    }
}
