<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectController extends Controller
{
    /**
     * Mostrar todos los proyectos.
     */
    public function index()
    {
        $proyectos = Proyecto::with('responsable')->get();
        return response()->json($proyectos);
    }

    /**
     * Guardar un nuevo proyecto.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'objetivo' => 'nullable|string',
            'beneficiarios' => 'nullable|string',
            'presupuesto_total' => 'nullable|numeric',
            'fondos_asignados' => 'nullable|numeric',
            'fondos_ejecutados' => 'nullable|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'in:planificado,en_progreso,pausado,finalizado,cancelado',
            'responsable_id' => 'nullable|exists:sys_users,id',
            'ubicacion' => 'nullable|string',
            'resultados_esperados' => 'nullable|string',
            'resultados_obtenidos' => 'nullable|string',
        ]);

        $proyecto = Proyecto::create($validated);

        return response()->json($proyecto, 201);
    }

    /**
     * Mostrar un proyecto específico.
     */
    public function show(Proyecto $proyecto)
    {
        return response()->json($proyecto->load('responsable'));
    }

    /**
     * Actualizar un proyecto.
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'objetivo' => 'nullable|string',
            'beneficiarios' => 'nullable|string',
            'presupuesto_total' => 'nullable|numeric',
            'fondos_asignados' => 'nullable|numeric',
            'fondos_ejecutados' => 'nullable|numeric',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'in:planificado,en_progreso,pausado,finalizado,cancelado',
            'responsable_id' => 'nullable|exists:sys_users,id',
            'ubicacion' => 'nullable|string',
            'resultados_esperados' => 'nullable|string',
            'resultados_obtenidos' => 'nullable|string',
        ]);

        $proyecto->update($validated);

        return response()->json($proyecto);
    }

    /**
     * Eliminar un proyecto.
     */
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();

        return response()->json(['message' => 'Proyecto eliminado correctamente']);
    }
}
