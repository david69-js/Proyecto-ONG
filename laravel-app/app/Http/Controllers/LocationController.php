<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        // Solo aplicar middleware de autenticación a rutas administrativas
        $this->middleware('auth')->except(['publicIndex', 'publicShow', 'publicIndex2', 'publicShow2']);
    }

    // Mostrar listado
    public function index()
    { 
        // Verificar autorización
        $this->authorize('viewAny', Location::class);

        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }

    /**
     * Vista pública del listado de ubicaciones
     */
    public function publicIndex(Request $request)
    {
        $query = Location::query();

        // Filtros opcionales
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('direccion', 'like', "%{$search}%")
                  ->orWhere('ciudad', 'like', "%{$search}%")
                  ->orWhere('pais', 'like', "%{$search}%");
            });
        }

        if ($request->filled('ciudad')) {
            $query->where('ciudad', $request->ciudad);
        }

        if ($request->filled('pais')) {
            $query->where('pais', $request->pais);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $locations = $query->get();

        // Obtener ciudades y países únicos para filtros
        $ciudades = Location::select('ciudad')->distinct()->whereNotNull('ciudad')->pluck('ciudad');
        $paises = Location::select('pais')->distinct()->whereNotNull('pais')->pluck('pais');

        return view('locations.public-index', compact('locations', 'ciudades', 'paises'));
    }

    /**
     * Vista pública de detalle de ubicación
     */
    public function publicShow(Location $location)
    {
        return view('locations.public-show', compact('location'));
    }

    // Mostrar formulario crear
    public function create()
    {
        // Verificar autorización
        $this->authorize('create', Location::class);

        return view('locations.create');
    }

    // Guardar nueva ubicación
    public function store(Request $request)
    {
        // Verificar autorización
        $this->authorize('create', Location::class);

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
        // Verificar autorización
        $this->authorize('view', $location);

        return view('locations.show', compact('location'));
    }

    // Mostrar formulario editar
    public function edit(Location $location)
    {
        // Verificar autorización
        $this->authorize('update', $location);

        return view('locations.edit', compact('location'));
    }

    // Actualizar registro
    public function update(Request $request, Location $location)
    {
        // Verificar autorización
        $this->authorize('update', $location);

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
        // Verificar autorización
        $this->authorize('delete', $location);

        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Ubicación eliminada correctamente');
    }

    /**
     * Vista pública del listado de ubicaciones (estilo dorado)
     */
    public function publicIndex2(Request $request)
    {
        $query = Location::query();

        // Filtros opcionales
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('direccion', 'like', "%{$search}%")
                  ->orWhere('ciudad', 'like', "%{$search}%")
                  ->orWhere('pais', 'like', "%{$search}%");
            });
        }

        if ($request->filled('ciudad')) {
            $query->where('ciudad', $request->ciudad);
        }

        if ($request->filled('pais')) {
            $query->where('pais', $request->pais);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $locations = $query->get();

        // Obtener ciudades y países únicos para filtros
        $ciudades = Location::select('ciudad')->distinct()->whereNotNull('ciudad')->pluck('ciudad');
        $paises = Location::select('pais')->distinct()->whereNotNull('pais')->pluck('pais');

        return view('locations.public-index2', compact('locations', 'ciudades', 'paises'));
    }

    /**
     * Vista pública de detalle de ubicación (estilo dorado)
     */
    public function publicShow2(Location $location)
    {
        return view('locations.public-show2', compact('location'));
    }
}
