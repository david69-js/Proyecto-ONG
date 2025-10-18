<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventRegistration extends Model
{
    use HasFactory;

    protected $table = 'ng_event_registrations';

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'notes',
        'status',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    /**
     * Relación con el evento
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Accessor para obtener el estado formateado
     */
    public function getStatusFormattedAttribute()
    {
        $statuses = [
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmado',
            'cancelled' => 'Cancelado',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Accessor para obtener el color del estado
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Scope para registros confirmados
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope para registros pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope para registros cancelados
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
