<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'donations';

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
        'amount'            => 'decimal:2',
        'is_anonymous'      => 'boolean',
        'is_tax_deductible' => 'boolean',
        'confirmed_at'      => 'datetime',
        'processed_at'      => 'datetime',
        'metadata'          => 'array',
    ];

    protected $attributes = [
        'currency' => 'GTQ',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    // Si tu modelo User usa la tabla "sys_users", asegúrate de que ese modelo tenga: protected $table = 'sys_users';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Debe existir un Project model con protected $table = 'ng_projects';
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Ya tienes Sponsor con protected $table = 'ng_sponsors';
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeByType($query, $type)
    {
        return $query->where('donation_type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeMonetary($query)
    {
        return $query->where('donation_type', 'monetary');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeByDonor($query, $donorEmail)
    {
        return $query->where('donor_email', $donorEmail);
    }

    public function scopeAnonymous($query)
    {
        return $query->where('is_anonymous', true);
    }

    public function scopeNotAnonymous($query)
    {
        return $query->where('is_anonymous', false);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors / Helpers
    |--------------------------------------------------------------------------
    */

    public function getDonationTypeFormattedAttribute()
    {
        $types = [
            'monetary'  => 'Monetaria',
            'materials' => 'Materiales',
            'services'  => 'Servicios',
            'volunteer' => 'Voluntariado',
            'mixed'     => 'Mixta',
        ];
        return $types[$this->donation_type] ?? $this->donation_type;
    }

    public function getDonorTypeFormattedAttribute()
    {
        $types = [
            'individual' => 'Individual',
            'corporate'  => 'Corporativo',
            'foundation' => 'Fundación',
            'ngo'        => 'ONG',
            'government' => 'Gobierno',
        ];
        return $types[$this->donor_type] ?? $this->donor_type;
    }

    public function getPaymentMethodFormattedAttribute()
    {
        $methods = [
            'transfer' => 'Transferencia',
            'cash'     => 'Efectivo',
            'check'    => 'Cheque',
            'kind'     => 'En Especie',
            'other'    => 'Otro',
        ];
        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getStatusFormattedAttribute()
    {
        $statuses = [
            'pending'   => 'Pendiente',
            'confirmed' => 'Confirmada',
            'processed' => 'Procesada',
            'rejected'  => 'Rechazada',
            'cancelled' => 'Cancelada',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

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

    public function getDonorDisplayNameAttribute()
    {
        return $this->is_anonymous ? 'Donante Anónimo' : $this->donor_name;
    }

    public function getReceiptUrlAttribute()
    {
        return $this->receipt_path ? asset('storage/' . $this->receipt_path) : null;
    }

    public function getTaxReceiptUrlAttribute()
    {
        return $this->tax_receipt_path ? asset('storage/' . $this->tax_receipt_path) : null;
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isProcessed()
    {
        return $this->status === 'processed';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isMonetary()
    {
        return $this->donation_type === 'monetary';
    }

    /*
    |--------------------------------------------------------------------------
    | Código / Boot
    |--------------------------------------------------------------------------
    */

    public static function generateDonationCode()
    {
        do {
            $code = 'DON-' . strtoupper(uniqid());
        } while (self::where('donation_code', $code)->exists());

        return $code;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($donation) {
            if (empty($donation->donation_code)) {
                $donation->donation_code = self::generateDonationCode();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Estadísticas
    |--------------------------------------------------------------------------
    */

    public static function getStatistics($filters = [])
    {
        $query = self::query();

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
            'total_donations'      => (clone $query)->count(),
            'total_amount'         => (clone $query)->monetary()->sum('amount'),
            'confirmed_donations'  => (clone $query)->confirmed()->count(),
            'processed_donations'  => (clone $query)->processed()->count(),
            'pending_donations'    => (clone $query)->pending()->count(),
        ];
    }
}
