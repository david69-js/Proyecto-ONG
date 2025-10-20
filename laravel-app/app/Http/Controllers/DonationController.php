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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DonationController extends Controller
{
    /** Permisos por acción (Spatie o tu middleware) */
    public function __construct()
    {
        // Ver / listar
        $this->middleware('permission:donations.view|donations.view.own')->only(['index', 'show']);
        // Crear
        $this->middleware('permission:donations.create')->only(['create', 'store']);
        // Editar
        $this->middleware('permission:donations.edit')->only(['edit', 'update']);
        // Eliminar
        $this->middleware('permission:donations.delete')->only(['destroy']);
        // Flujos de estado
        $this->middleware('permission:donations.confirm')->only(['confirm']);
        $this->middleware('permission:donations.process')->only(['process']);
        $this->middleware('permission:donations.reject')->only(['reject']);
        $this->middleware('permission:donations.cancel')->only(['cancel']);
        // Reportes / export
        $this->middleware('permission:donations.reports')->only(['reports', 'export']);
    }

    /** Helper: resuelve nombre de ruta admin.* o sin prefijo */
    private function routeName(string $suffix): string
    {
        $admin = "admin.donations.$suffix";
        $flat  = "donations.$suffix";
        return app('router')->has($admin) ? $admin : $flat;
    }

    /** Helper: base de vistas dinámica (sections/donations/* o donations/*) */
    private function viewBase(): string
    {
        return view()->exists('sections.donations.index') ? 'sections.donations.' : 'donations.';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Donation::with(['user', 'project', 'sponsor', 'confirmedBy', 'processedBy']);

        // Filtros
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
            // incluir todo el día de date_to
            $query->where('created_at', '<=', Carbon::parse($request->date_to)->endOfDay());
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

        // Ver solo propias si no tiene permiso global
        if (Auth::user()->hasPermission('donations.view.own') && !Auth::user()->hasPermission('donations.view')) {
            $query->where('user_id', Auth::id());
        }

        $donations = $query->orderBy('created_at', 'desc')->paginate(15);

        // Datos para filtros
        $projects = Project::select('id', 'nombre')->get();
        $sponsors = Sponsor::select('id', 'name')->get();

        return view($this->viewBase().'index', compact('donations', 'projects', 'sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('estado', '!=', 'finalizado')->get();
        $sponsors = Sponsor::where('status', 'active')->get();
        $users = User::where('is_active', true)->get();

        return view($this->viewBase().'create', compact('projects', 'sponsors', 'users'));
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
            'payment_method' => ['required', Rule::in(['transfer', 'cash', 'check', 'kind', 'other', 'paypal'])],
            'payment_reference' => 'nullable|string|max:255',
            'payment_notes' => 'nullable|string|max:500',
            'special_instructions' => 'nullable|string|max:1000',
            'is_tax_deductible' => 'boolean',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['currency'] = strtoupper($data['currency'] ?? 'USD');
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        // Archivo de comprobante
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = 'donations/receipts/' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public', $filename);
            $data['receipt_path'] = $filename;
        }

        // Usuario autenticado por defecto
        if (empty($data['user_id'])) {
            $data['user_id'] = Auth::id();
        }

        $donation = Donation::create($data);

        return redirect()->route($this->routeName('show'), $donation)
            ->with('success', 'Donación creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        $donation->load(['user', 'project', 'sponsor', 'confirmedBy', 'processedBy', 'createdBy', 'updatedBy']);
        return view($this->viewBase().'show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        $projects = Project::where('estado', '!=', 'finalizado')->get();
        $sponsors = Sponsor::where('status', 'active')->get();
        $users = User::where('is_active', true)->get();

        return view($this->viewBase().'edit', compact('donation', 'projects', 'sponsors', 'users'));
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
            'payment_method' => ['required', Rule::in(['transfer', 'cash', 'check', 'kind', 'other', 'paypal'])],
            'payment_reference' => 'nullable|string|max:255',
            'payment_notes' => 'nullable|string|max:500',
            'special_instructions' => 'nullable|string|max:1000',
            'is_tax_deductible' => 'boolean',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status_notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['currency'] = strtoupper($data['currency'] ?? $donation->currency);
        $data['updated_by'] = Auth::id();

        // Reemplazo de archivo
        if ($request->hasFile('receipt')) {
            if ($donation->receipt_path) {
                Storage::disk('public')->delete($donation->receipt_path);
            }
            $file = $request->file('receipt');
            $filename = 'donations/receipts/' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public', $filename);
            $data['receipt_path'] = $filename;
        }

        $donation->update($data);

        return redirect()->route($this->routeName('show'), $donation)
            ->with('success', 'Donación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        if ($donation->status !== 'pending') {
            return back()->with('error', 'Solo se pueden eliminar donaciones pendientes.');
        }

        if ($donation->receipt_path) {
            Storage::disk('public')->delete($donation->receipt_path);
        }
        if ($donation->tax_receipt_path) {
            Storage::disk('public')->delete($donation->tax_receipt_path);
        }

        $donation->delete();

        return redirect()->route($this->routeName('index'))
            ->with('success', 'Donación eliminada exitosamente.');
    }

    /** Confirm a donation */
    public function confirm(Request $request, Donation $donation)
    {
        $request->validate([
            'status_notes' => 'nullable|string|max:500',
        ]);

        if ($donation->status !== 'pending') {
            return back()->with('error', 'Solo se pueden confirmar donaciones pendientes.');
        }

        $donation->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::id(),
            'status_notes' => $request->status_notes,
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Donación confirmada exitosamente.');
    }

    /** Process a donation */
    public function process(Request $request, Donation $donation)
    {
        $request->validate([
            'status_notes' => 'nullable|string|max:500',
            'tax_receipt_number' => 'nullable|string|max:255',
            'tax_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($donation->status !== 'confirmed') {
            return back()->with('error', 'Solo se pueden procesar donaciones confirmadas.');
        }

        $data = [
            'status' => 'processed',
            'processed_at' => now(),
            'processed_by' => Auth::id(),
            'status_notes' => $request->status_notes,
            'tax_receipt_number' => $request->tax_receipt_number,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('tax_receipt')) {
            if ($donation->tax_receipt_path) {
                Storage::disk('public')->delete($donation->tax_receipt_path);
            }
            $file = $request->file('tax_receipt');
            $filename = 'donations/tax-receipts/' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public', $filename);
            $data['tax_receipt_path'] = $filename;
        }

        $donation->update($data);

        return back()->with('success', 'Donación procesada exitosamente.');
    }

    /** Reject a donation */
    public function reject(Request $request, Donation $donation)
    {
        $request->validate([
            'status_notes' => 'required|string|max:500',
        ]);

        if (!in_array($donation->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Solo se pueden rechazar donaciones pendientes o confirmadas.');
        }

        $donation->update([
            'status' => 'rejected',
            'status_notes' => $request->status_notes,
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Donación rechazada exitosamente.');
    }

    /** Cancel a donation */
    public function cancel(Request $request, Donation $donation)
    {
        $request->validate([
            'status_notes' => 'nullable|string|max:500',
        ]);

        if (!in_array($donation->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Solo se pueden cancelar donaciones pendientes o confirmadas.');
        }

        $donation->update([
            'status' => 'cancelled',
            'status_notes' => $request->status_notes,
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Donación cancelada exitosamente.');
    }

    /** Show donation reports */
    public function reports(Request $request)
    {
        $filters = $request->only(['project_id', 'date_from', 'date_to', 'status']);
        $statistics = Donation::getStatistics($filters);

        $donationsByType = Donation::selectRaw('donation_type, COUNT(*) as count')
            ->when($request->filled('date_from'), fn($q) => $q->where('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->where('created_at', '<=', Carbon::parse($request->date_to)->endOfDay()))
            ->groupBy('donation_type')
            ->get();

        $donationsByStatus = Donation::selectRaw('status, COUNT(*) as count')
            ->when($request->filled('date_from'), fn($q) => $q->where('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->where('created_at', '<=', Carbon::parse($request->date_to)->endOfDay()))
            ->groupBy('status')
            ->get();

        $dateFormat = config('database.default') === 'sqlite'
            ? 'strftime("%Y-%m", created_at)'
            : 'DATE_FORMAT(created_at, "%Y-%m")';

        $monthlyDonations = Donation::selectRaw("$dateFormat as month, SUM(amount) as total")
            ->where('donation_type', 'monetary')
            ->when($request->filled('date_from'), fn($q) => $q->where('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->where('created_at', '<=', Carbon::parse($request->date_to)->endOfDay()))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $projects = Project::select('id', 'nombre')->get();

        return view($this->viewBase().'reports', compact(
            'statistics',
            'donationsByType',
            'donationsByStatus',
            'monthlyDonations',
            'projects'
        ));
    }

    /** Export donations data */
    public function export(Request $request)
    {
        $query = Donation::with(['user', 'project', 'sponsor']);

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
            $query->where('created_at', '<=', Carbon::parse($request->date_to)->endOfDay());
        }

        $donations = $query->get();
        $filename = 'donaciones_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($donations) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Código','Tipo','Monto','Moneda','Descripción','Donante','Email','Teléfono',
                'Tipo Donante','Proyecto','Patrocinador','Método Pago','Estado',
                'Fecha Creación','Fecha Confirmación','Fecha Procesamiento',
            ]);

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
                    optional($donation->created_at)->format('Y-m-d H:i:s'),
                    optional($donation->confirmed_at)->format('Y-m-d H:i:s'),
                    optional($donation->processed_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /** ---------- PayPal ---------- */

    private function paypalBaseUrl(): string
    {
        $mode = env('PAYPAL_MODE', 'sandbox');
        return $mode === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
    }

    private function paypalAccessToken()
    {
        $resp = Http::asForm()
            ->withBasicAuth(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SECRET'))
            ->post($this->paypalBaseUrl() . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$resp->successful()) {
            return response()->json(['error' => 'paypal_oauth_error', 'details' => $resp->json()], 500);
        }
        return $resp->json()['access_token'];
    }

    /** Crear orden PayPal y crear Donation (pending) */
    public function createPaypalOrder(Request $request)
    {
        $validated = $request->validate([
            'amount'      => 'required|numeric|min:1',
            'donor_name'  => 'nullable|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'project_id'  => 'nullable|exists:ng_projects,id',
            'notes'       => 'nullable|string|max:500',
            'currency'    => 'nullable|string|size:3',
        ]);

        $amount   = number_format($validated['amount'], 2, '.', '');
        $currency = strtoupper($validated['currency'] ?? env('PAYPAL_CURRENCY', 'USD'));

        // 1) Crear la orden en PayPal
        $token = $this->paypalAccessToken();
        if (is_object($token)) return $token; // error json

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $currency,
                    'value' => $amount,
                ],
                'description' => 'Donación ONG',
            ]],
            'application_context' => [
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
            ],
        ];

        $resp = Http::withToken($token)->post($this->paypalBaseUrl() . '/v2/checkout/orders', $payload);

        if (!$resp->successful()) {
            return response()->json(['error' => 'paypal_create_error', 'details' => $resp->json()], 500);
        }

        $order = $resp->json();
        $orderId = $order['id'] ?? null;

        // 2) Crear Donation (pending)
        $donationData = [
            'donation_type'   => 'monetary',
            'amount'          => $amount,
            'currency'        => $currency,
            'description'     => 'Donación vía PayPal',
            'donor_name'      => $validated['donor_name'] ?? 'Donante',
            'donor_email'     => $validated['donor_email'] ?? null,
            'donor_type'      => 'individual',
            'is_anonymous'    => false,
            'user_id'         => auth()->id() ?: null,
            'project_id'      => $validated['project_id'] ?? null,
            'payment_method'  => 'paypal',
            'payment_reference' => $orderId,
            'payment_notes'   => $validated['notes'] ?? null,
            'status'          => 'pending',
            'created_by'      => auth()->id() ?: null,
            'updated_by'      => auth()->id() ?: null,
            'metadata'        => [
                'paypal_order' => $order,
            ],
        ];

        $donation = Donation::create($donationData);

        return response()->json([
            'id' => $orderId,
            'donation_id' => $donation->id,
            'links' => $order['links'] ?? [],
        ]);
    }

    /** Capturar orden PayPal y actualizar Donation */
    public function capturePaypalOrder(Request $request)
    {
        $validated = $request->validate([
            'orderID'     => 'required|string',
            'donation_id' => 'nullable|integer',
        ]);

        $token = $this->paypalAccessToken();
        if (is_object($token)) return $token; // error json

        $orderId = $validated['orderID'];

        $resp = Http::withToken($token)
            ->post($this->paypalBaseUrl() . "/v2/checkout/orders/{$orderId}/capture", []);

        if (!$resp->successful()) {
            return response()->json(['error' => 'paypal_capture_error', 'details' => $resp->json()], 500);
        }

        $capture = $resp->json();

        // Buscar Donation
        $donation = null;
        if (!empty($validated['donation_id'])) {
            $donation = Donation::find($validated['donation_id']);
        }
        if (!$donation) {
            $donation = Donation::where('payment_reference', $orderId)->first();
        }

        if ($donation) {
            $payer = $capture['payer'] ?? [];
            $captures = $capture['purchase_units'][0]['payments']['captures'] ?? [];
            $firstCap = $captures[0] ?? [];
            $captureId = $firstCap['id'] ?? null;
            $status = strtolower($firstCap['status'] ?? ($capture['status'] ?? 'COMPLETED'));

            // COMPLETED -> processed (puedes cambiar a confirmed si tu flujo lo requiere)
            $toStatus = ($status === 'completed') ? 'processed' : 'confirmed';

            $donation->update([
                'status'           => $toStatus,
                'processed_at'     => now(),
                'processed_by'     => auth()->id() ?: null,
                'status_notes'     => 'Pago PayPal ' . strtoupper($status),
                'updated_by'       => auth()->id() ?: null,
                'payment_reference'=> $captureId ?: $orderId,
                'metadata'         => array_merge($donation->metadata ?? [], [
                    'paypal_capture' => $capture,
                    'paypal_payer'   => $payer,
                ]),
                'donor_email'      => $donation->donor_email ?: ($payer['email_address'] ?? null),
                'donor_name'       => $donation->donor_name  ?: trim(($payer['name']['given_name'] ?? '') . ' ' . ($payer['name']['surname'] ?? '')),
            ]);
        }

        return response()->json($capture);
    }
}
