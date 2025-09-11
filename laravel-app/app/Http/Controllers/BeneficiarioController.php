<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiario;

class BeneficiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
     // Datos de ejemplo sin BD
    $beneficiarios = [
        ['id' => 1, 'nombre' => 'Juan', 'apellido' => 'Pérez', 'email' => 'juan@example.com', 'telefono' => '12345678', 'direccion' => 'Ciudad A'],
        ['id' => 2, 'nombre' => 'María', 'apellido' => 'Gómez', 'email' => 'maria@example.com', 'telefono' => '87654321', 'direccion' => 'Ciudad B'],
    ];

    return view('beneficiarios.index', compact('beneficiarios'));
    
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('beneficiarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
