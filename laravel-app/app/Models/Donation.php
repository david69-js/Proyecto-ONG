<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'donation_code',
        'donation_type',
        'amount',
        'currency',
        'description',
        'donor_name',
        'donor_email',
        'donor_phone',
        'donor_address',
        'donor_type',
        'is_anonymous',
        'user_id',
        'project_id',
        'sponsor_id',
        'payment_method',
        'payment_reference',
        'payment_notes',
        'status',
        'status_notes',
        'confirmed_at',
        'processed_at',
        'confirmed_by',
        'processed_by',
        'special_instructions',
        'metadata',
        'is_tax_deductible',
        'tax_receipt_number',
        'receipt_path',
        'tax_receipt_path',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'is_tax_deductible' => 'boolean',
        'confirmed_at' => 'datetime',
        'processed_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected $attributes = [
        'currency' => 'GTQ',
    ];

    /**
     * Relación con el usuario donante (si está registrado)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el proyecto
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relación con el patrocinador
     */
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    /**
     * Usuario que confirmó la donación
     */
    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /**
     * Usuario que procesó la donación
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Usuario que creó el registro
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Usuario que actualizó el registro
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope para donaciones por tipo
     */
    public function scopeByType($query, $type)
    {
        return $query->where('donation_type', $type);
    }

    /**
     * Scope para donaciones por estado
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para donaciones monetarias
     */
    public function scopeMonetary($query)
    {
        return $query->where('donation_type', 'monetary');
    }

    /**
     * Scope para donaciones confirmadas
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope para donaciones procesadas
     */
    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    /**
     * Scope para donaciones pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope para donaciones por proyecto
     */
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Scope para donaciones por donante
     */
    public function scopeByDonor($query, $donorEmail)
    {
        return $query->where('donor_email', $donorEmail);
    }

    /**
     * Scope para donaciones anónimas
     */
    public function scopeAnonymous($query)
    {
        return $query->where('is_anonymous', true);
    }

    /**
     * Scope para donaciones no anónimas
     */
    public function scopeNotAnonymous($query)
    {
        return $query->where('is_anonymous', false);
    }

    /**
     * Accessor para el tipo de donación formateado
     */
    public function getDonationTypeFormattedAttribute()
    {
        $types = [
            'monetary' => 'Monetaria',
            'materials' => 'Materiales',
            'services' => 'Servicios',
            'volunteer' => 'Voluntariado',
            'mixed' => 'Mixta',
        ];

        return $types[$this->donation_type] ?? $this->donation_type;
    }

    /**
     * Accessor para el tipo de donante formateado
     */
    public function getDonorTypeFormattedAttribute()
    {
        $types = [
            'individual' => 'Individual',
            'corporate' => 'Corporativo',
            'foundation' => 'Fundación',
            'ngo' => 'ONG',
            'government' => 'Gobierno',
        ];

        return $types[$this->donor_type] ?? $this->donor_type;
    }

    /**
     * Accessor para el método de pago formateado
     */
    public function getPaymentMethodFormattedAttribute()
    {
        $methods = [
            'transfer' => 'Transferencia',
            'cash' => 'Efectivo',
            'check' => 'Cheque',
            'kind' => 'En Especie',
            'other' => 'Otro',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    /**
     * Accessor para el estado formateado
     */
    public function getStatusFormattedAttribute()
    {
        $statuses = [
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmada',
            'processed' => 'Procesada',
            'rejected' => 'Rechazada',
            'cancelled' => 'Cancelada',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Accessor para el monto formateado
     */
    public function getFormattedAmountAttribute()
    {
        if (!$this->amount) {
            return 'N/A';
        }

        $symbols = [
            'GTQ' => 'Q',
            'USD' => '$',
            'EUR' => '€',
            'MXN' => '$',
        ];

        $symbol = $symbols[$this->currency] ?? $this->currency;
        return $symbol . number_format($this->amount, 2);
    }

    /**
     * Accessor para el nombre del donante (considerando anonimato)
     */
    public function getDonorDisplayNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Donante Anónimo';
        }

        return $this->donor_name;
    }

    /**
     * Accessor para la URL del comprobante
     */
    public function getReceiptUrlAttribute()
    {
        if ($this->receipt_path) {
            return asset('storage/' . $this->receipt_path);
        }
        return null;
    }

    /**
     * Accessor para la URL del recibo fiscal
     */
    public function getTaxReceiptUrlAttribute()
    {
        if ($this->tax_receipt_path) {
            return asset('storage/' . $this->tax_receipt_path);
        }
        return null;
    }

    /**
     * Verificar si la donación está confirmada
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    /**
     * Verificar si la donación está procesada
     */
    public function isProcessed()
    {
        return $this->status === 'processed';
    }

    /**
     * Verificar si la donación está pendiente
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Verificar si la donación es monetaria
     */
    public function isMonetary()
    {
        return $this->donation_type === 'monetary';
    }

    /**
     * Generar código único de donación
     */
    public static function generateDonationCode()
    {
        do {
            $code = 'DON-' . strtoupper(uniqid());
        } while (self::where('donation_code', $code)->exists());

        return $code;
    }


    /**
     * Boot method para generar código automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($donation) {
            if (empty($donation->donation_code)) {
                $donation->donation_code = self::generateDonationCode();
            }
        });
    }

    /**
     * Obtener estadísticas de donaciones
     */
    public static function getStatistics($filters = [])
    {
        $query = self::query();

        // Aplicar filtros
        if (isset($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return [
            'total_donations' => $query->count(),
            'total_amount' => $query->monetary()->sum('amount'),
            'confirmed_donations' => (clone $query)->confirmed()->count(),
            'processed_donations' => (clone $query)->processed()->count(),
            'pending_donations' => (clone $query)->pending()->count(),
        ];
    }
}
