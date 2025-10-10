<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Project;
use App\Policies\BeneficiaryPolicy;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verificar autorización
        $this->authorize('viewAny', Beneficiary::class);

        // Filtrar beneficiarios según el rol del usuario
        $query = Beneficiary::with(['project', 'user']);
        $beneficiaries = BeneficiaryPolicy::scopeForUser(auth()->user(), $query)->get();

        return view('beneficiaries.index', compact('beneficiaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar autorización
        $this->authorize('create', Beneficiary::class);

        $projects = Project::all();
        return view('beneficiaries.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar autorización
        $this->authorize('create', Beneficiary::class);

        $request->validate([
            'user_id' => 'nullable|exists:sys_users,id',
            'name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'beneficiary_type' => 'nullable|string',
            'status' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'notes' => 'nullable|string',
        ]);

        Beneficiary::create($request->all());

        return redirect()->route('beneficiaries.index')
                         ->with('success', 'Beneficiario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Beneficiary $beneficiary)
    {
        // Verificar autorización
        $this->authorize('view', $beneficiary);

        $beneficiary->load(['project', 'user']);
        return view('beneficiaries.show', compact('beneficiary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beneficiary $beneficiary)
    {
        // Verificar autorización
        $this->authorize('update', $beneficiary);

        $projects = Project::all();
        return view('beneficiaries.edit', compact('beneficiary', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beneficiary $beneficiary)
    {
        // Verificar autorización
        $this->authorize('update', $beneficiary);

        $request->validate([
            'user_id' => 'nullable|exists:sys_users,id',
            'name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'beneficiary_type' => 'nullable|string',
            'status' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'notes' => 'nullable|string',
        ]);

        $beneficiary->update($request->all());

        return redirect()->route('beneficiaries.index')
                     ->with('success', 'Beneficiario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beneficiary $beneficiary)
    {
        // Verificar autorización
        $this->authorize('delete', $beneficiary);

        $beneficiary->delete();

        return redirect()->route('beneficiaries.index')
                     ->with('success', 'Beneficiary deleted successfully.');
    }
}
