<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Project;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Donation::with(['user', 'project', 'sponsor', 'confirmedBy', 'processedBy']);

        // Aplicar filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('donation_type')) {
            $query->where('donation_type', $request->donation_type);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('donor_type')) {
            $query->where('donor_type', $request->donor_type);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donation_code', 'like', "%{$search}%")
                  ->orWhere('donor_name', 'like', "%{$search}%")
                  ->orWhere('donor_email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Si el usuario solo puede ver sus propias donaciones
        if (Auth::user()->hasPermission('donations.view.own') && !Auth::user()->hasPermission('donations.view')) {
            $query->where('user_id', Auth::id());
        }

        $donations = $query->orderBy('created_at', 'desc')->paginate(15);

        // Obtener datos para filtros
        $projects = Project::select('id', 'nombre')->get();
        $sponsors = Sponsor::select('id', 'name')->get();

        return view('donations.index', compact('donations', 'projects', 'sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('estado', '!=', 'cancelado')->get();
        $sponsors = Sponsor::where('status', 'active')->get();
        $users = User::where('is_active', true)->get();

        return view('donations.create', compact('projects', 'sponsors', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'donation_type' => ['required', Rule::in(['monetary', 'materials', 'services', 'volunteer', 'mixed'])],
            'amount' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'description' => 'required|string|max:1000',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'donor_address' => 'nullable|string|max:500',
            'donor_type' => ['required', Rule::in(['individual', 'corporate', 'foundation', 'ngo', 'government'])],
            'is_anonymous' => 'boolean',
            'user_id' => 'nullable|exists:sys_users,id',
            'project_id' => 'nullable|exists:ng_projects,id',
            'sponsor_id' => 'nullable|exists:ng_sponsors,id',
            'payment_method' => ['required', Rule::in(['transfer', 'cash', 'check', 'kind', 'other'])],
            'payment_reference' => 'nullable|string|max:255',
            'payment_notes' => 'nullable|string|max:500',
            'special_instructions' => 'nullable|string|max:1000',
            'is_tax_deductible' => 'boolean',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        // Manejar archivo de comprobante
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = 'donations/receipts/' . time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $data['receipt_path'] = $filename;
        }

        // Si no se especifica usuario, usar el usuario autenticado
        if (empty($data['user_id'])) {
            $data['user_id'] = Auth::id();
        }

        $donation = Donation::create($data);

        return redirect()->route('donations.show', $donation)
            ->with('success', 'Donación creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        $donation->load(['user', 'project', 'sponsor', 'confirmedBy', 'processedBy', 'createdBy', 'updatedBy']);

        return view('donations.show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        $projects = Project::where('estado', '!=', 'cancelado')->get();
        $sponsors = Sponsor::where('status', 'active')->get();
        $users = User::where('is_active', true)->get();

        return view('donations.edit', compact('donation', 'projects', 'sponsors', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        $validator = Validator::make($request->all(), [
            'donation_type' => ['required', Rule::in(['monetary', 'materials', 'services', 'volunteer', 'mixed'])],
            'amount' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'description' => 'required|string|max:1000',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'donor_address' => 'nullable|string|max:500',
            'donor_type' => ['required', Rule::in(['individual', 'corporate', 'foundation', 'ngo', 'government'])],
            'is_anonymous' => 'boolean',
            'user_id' => 'nullable|exists:sys_users,id',
            'project_id' => 'nullable|exists:ng_projects,id',
            'sponsor_id' => 'nullable|exists:ng_sponsors,id',
            'payment_method' => ['required', Rule::in(['transfer', 'cash', 'check', 'kind', 'other'])],
            'payment_reference' => 'nullable|string|max:255',
            'payment_notes' => 'nullable|string|max:500',
            'special_instructions' => 'nullable|string|max:1000',
            'is_tax_deductible' => 'boolean',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status_notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['updated_by'] = Auth::id();

        // Manejar archivo de comprobante
        if ($request->hasFile('receipt')) {
            // Eliminar archivo anterior si existe
            if ($donation->receipt_path) {
                Storage::disk('public')->delete($donation->receipt_path);
            }

            $file = $request->file('receipt');
            $filename = 'donations/receipts/' . time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $data['receipt_path'] = $filename;
        }

        $donation->update($data);

        return redirect()->route('donations.show', $donation)
            ->with('success', 'Donación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        // Solo permitir eliminar donaciones pendientes
        if ($donation->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Solo se pueden eliminar donaciones pendientes.');
        }

        // Eliminar archivos asociados
        if ($donation->receipt_path) {
            Storage::disk('public')->delete($donation->receipt_path);
        }

        if ($donation->tax_receipt_path) {
            Storage::disk('public')->delete($donation->tax_receipt_path);
        }

        $donation->delete();

        return redirect()->route('donations.index')
            ->with('success', 'Donación eliminada exitosamente.');
    }

    /**
     * Confirm a donation
     */
    public function confirm(Request $request, Donation $donation)
    {
        $request->validate([
            'status_notes' => 'nullable|string|max:500',
        ]);

        if ($donation->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Solo se pueden confirmar donaciones pendientes.');
        }

        $donation->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::id(),
            'status_notes' => $request->status_notes,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()
            ->with('success', 'Donación confirmada exitosamente.');
    }

    /**
     * Process a donation
     */
    public function process(Request $request, Donation $donation)
    {
        $request->validate([
            'status_notes' => 'nullable|string|max:500',
            'tax_receipt_number' => 'nullable|string|max:255',
            'tax_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($donation->status !== 'confirmed') {
            return redirect()->back()
                ->with('error', 'Solo se pueden procesar donaciones confirmadas.');
        }

        $data = [
            'status' => 'processed',
            'processed_at' => now(),
            'processed_by' => Auth::id(),
            'status_notes' => $request->status_notes,
            'tax_receipt_number' => $request->tax_receipt_number,
            'updated_by' => Auth::id(),
        ];

        // Manejar archivo de recibo fiscal
        if ($request->hasFile('tax_receipt')) {
            // Eliminar archivo anterior si existe
            if ($donation->tax_receipt_path) {
                Storage::disk('public')->delete($donation->tax_receipt_path);
            }

            $file = $request->file('tax_receipt');
            $filename = 'donations/tax-receipts/' . time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $data['tax_receipt_path'] = $filename;
        }

        $donation->update($data);

        return redirect()->back()
            ->with('success', 'Donación procesada exitosamente.');
    }

    /**
     * Reject a donation
     */
    public function reject(Request $request, Donation $donation)
    {
        $request->validate([
            'status_notes' => 'required|string|max:500',
        ]);

        if (!in_array($donation->status, ['pending', 'confirmed'])) {
            return redirect()->back()
                ->with('error', 'Solo se pueden rechazar donaciones pendientes o confirmadas.');
        }

        $donation->update([
            'status' => 'rejected',
            'status_notes' => $request->status_notes,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()
            ->with('success', 'Donación rechazada exitosamente.');
    }

    /**
     * Cancel a donation
     */
    public function cancel(Request $request, Donation $donation)
    {
        $request->validate([
            'status_notes' => 'nullable|string|max:500',
        ]);

        if (!in_array($donation->status, ['pending', 'confirmed'])) {
            return redirect()->back()
                ->with('error', 'Solo se pueden cancelar donaciones pendientes o confirmadas.');
        }

        $donation->update([
            'status' => 'cancelled',
            'status_notes' => $request->status_notes,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()
            ->with('success', 'Donación cancelada exitosamente.');
    }

    /**
     * Show donation reports
     */
    public function reports(Request $request)
    {
        $filters = $request->only(['project_id', 'date_from', 'date_to', 'status']);
        $statistics = Donation::getStatistics($filters);

        // Obtener datos para gráficos
        $donationsByType = Donation::selectRaw('donation_type, COUNT(*) as count')
            ->when($request->filled('date_from'), function ($query) use ($request) {
                return $query->where('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                return $query->where('created_at', '<=', $request->date_to);
            })
            ->groupBy('donation_type')
            ->get();

        $donationsByStatus = Donation::selectRaw('status, COUNT(*) as count')
            ->when($request->filled('date_from'), function ($query) use ($request) {
                return $query->where('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                return $query->where('created_at', '<=', $request->date_to);
            })
            ->groupBy('status')
            ->get();

        $monthlyDonations = Donation::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total')
            ->where('donation_type', 'monetary')
            ->when($request->filled('date_from'), function ($query) use ($request) {
                return $query->where('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                return $query->where('created_at', '<=', $request->date_to);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $projects = Project::select('id', 'nombre')->get();

        return view('donations.reports', compact(
            'statistics',
            'donationsByType',
            'donationsByStatus',
            'monthlyDonations',
            'projects'
        ));
    }

    /**
     * Export donations data
     */
    public function export(Request $request)
    {
        $query = Donation::with(['user', 'project', 'sponsor']);

        // Aplicar filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('donation_type')) {
            $query->where('donation_type', $request->donation_type);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $donations = $query->get();

        $filename = 'donaciones_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($donations) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'Código',
                'Tipo',
                'Monto',
                'Moneda',
                'Descripción',
                'Donante',
                'Email',
                'Teléfono',
                'Tipo Donante',
                'Proyecto',
                'Patrocinador',
                'Método Pago',
                'Estado',
                'Fecha Creación',
                'Fecha Confirmación',
                'Fecha Procesamiento',
            ]);

            // Data
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->donation_code,
                    $donation->donation_type_formatted,
                    $donation->amount,
                    $donation->currency,
                    $donation->description,
                    $donation->donor_display_name,
                    $donation->donor_email,
                    $donation->donor_phone,
                    $donation->donor_type_formatted,
                    $donation->project?->nombre,
                    $donation->sponsor?->name,
                    $donation->payment_method_formatted,
                    $donation->status_formatted,
                    $donation->created_at->format('Y-m-d H:i:s'),
                    $donation->confirmed_at?->format('Y-m-d H:i:s'),
                    $donation->processed_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
