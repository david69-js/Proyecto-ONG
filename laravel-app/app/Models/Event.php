<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'ng_events';

    protected $fillable = [
        'title',
        'description',
        'event_type',
        'start_date',
        'end_date',
        'location',
        'address',
        'max_participants',
        'current_participants',
        'registration_required',
        'registration_deadline',
        'cost',
        'status',
        'featured',
        'image_path',
        'contact_email',
        'contact_phone',
        'requirements',
        'created_by',
        'project_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'cost' => 'decimal:2',
        'registration_required' => 'boolean',
        'featured' => 'boolean',
    ];

    /**
     * Relación con el usuario que creó el evento
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con el proyecto asociado
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relación con los registros del evento
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Scope para eventos publicados
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope para eventos destacados
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope para eventos próximos
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    /**
     * Scope para eventos pasados
     */
    public function scopePast($query)
    {
        return $query->where('start_date', '<', now());
    }

    /**
     * Accessor para obtener el tipo de evento formateado
     */
    public function getEventTypeFormattedAttribute()
    {
        $types = [
            'fundraising' => 'Recaudación de Fondos',
            'volunteer' => 'Voluntariado',
            'awareness' => 'Concientización',
            'community' => 'Comunitario',
            'training' => 'Capacitación',
            'other' => 'Otro',
        ];

        return $types[$this->event_type] ?? $this->event_type;
    }

    /**
     * Accessor para obtener el estado formateado
     */
    public function getStatusFormattedAttribute()
    {
        $statuses = [
            'draft' => 'Borrador',
            'published' => 'Publicado',
            'cancelled' => 'Cancelado',
            'completed' => 'Completado',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Accessor para obtener la URL de la imagen
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('assets/img/default-event.jpg');
    }

    /**
     * Accessor para verificar si el evento está próximo
     */
    public function getIsUpcomingAttribute()
    {
        return $this->start_date > now();
    }

    /**
     * Accessor para verificar si el evento está en progreso
     */
    public function getIsInProgressAttribute()
    {
        $now = now();
        return $this->start_date <= $now && ($this->end_date === null || $this->end_date >= $now);
    }

    /**
     * Accessor para verificar si el evento ha terminado
     */
    public function getIsPastAttribute()
    {
        return $this->end_date ? $this->end_date < now() : $this->start_date < now();
    }

    /**
     * Accessor para verificar si hay cupos disponibles
     */
    public function getHasAvailableSpotsAttribute()
    {
        if (!$this->max_participants) {
            return true;
        }
        return $this->current_participants < $this->max_participants;
    }

    /**
     * Accessor para verificar si el registro está abierto
     */
    public function getIsRegistrationOpenAttribute()
    {
        if (!$this->registration_required) {
            return false;
        }
        
        if ($this->registration_deadline && $this->registration_deadline < now()) {
            return false;
        }
        
        return $this->has_available_spots;
    }

    /**
     * Accessor para obtener el color del tipo de evento
     */
    public function getEventTypeColorAttribute()
    {
        $colors = [
            'fundraising' => 'danger',
            'volunteer' => 'success',
            'awareness' => 'info',
            'community' => 'warning',
            'training' => 'primary',
            'other' => 'secondary',
        ];

        return $colors[$this->event_type] ?? 'secondary';
    }

    /**
     * Accessor para obtener el color del estado
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'draft' => 'secondary',
            'published' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Actualizar contador de participantes
     */
    public function updateParticipantsCount()
    {
        $this->current_participants = $this->registrations()->where('status', '!=', 'cancelled')->count();
        $this->save();
    }
}
