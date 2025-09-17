<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beneficiaries = Beneficiary::all();
        return view('beneficiaries.index', compact('beneficiaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('beneficiaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        Beneficiary::create($request->all());

        return redirect()->route('beneficiaries.index')
                         ->with('success', 'Beneficiary created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        return view('beneficiaries.show', compact('beneficiary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        return view('beneficiaries.edit', compact('beneficiary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $beneficiary = Beneficiary::findOrFail($id);

        $beneficiary->update($request->all());

        return redirect()->route('beneficiaries.index')
                     ->with('success', 'Beneficiario actualizado correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $beneficiary->delete();

        // Redireccionamos a la lista de beneficiarios, no a una vista con $beneficiary
        return redirect()->route('beneficiaries.index')
                     ->with('success', 'Beneficiary deleted successfully.');
        }
}
