<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SponsorHighlight;

class Sponsor extends Model
{
    use HasFactory;

    protected $table = 'ng_sponsors';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'company_name',
        'contact_person',
        'email',
        'phone',
        'address',
        'website',
        'sponsor_type',
        'contribution_type',
        'contribution_amount',
        'contribution_description',
        'status',
        'partnership_start_date',
        'partnership_end_date',
        'logo_path',
        'description',
        'notes',
        'is_featured',
        'priority_level',
    ];

    protected $casts = [
        'partnership_start_date' => 'date',
        'partnership_end_date' => 'date',
        'contribution_amount' => 'decimal:2',
        'is_featured' => 'boolean',
        'priority_level' => 'integer',
    ];

    /**
     * Relación con proyectos patrocinados
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'rel_sponsor_projects')
                    ->withPivot('contribution_amount', 'contribution_type', 'sponsorship_date', 'notes')
                    ->withTimestamps();
    }

    /**
     * Relación con donaciones (comentado hasta que se implemente el modelo Donation)
     */
    // public function donations()
    // {
    //     return $this->hasMany(Donation::class);
    // }

    /**
     * Scope para patrocinadores activos
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope para patrocinadores destacados
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope para ordenar por prioridad
     */
    public function scopeByPriority($query)
    {
        return $query->orderBy('priority_level', 'desc')
                    ->orderBy('contribution_amount', 'desc');
    }

    /**
     * Accessor para obtener el tipo de patrocinador formateado
     */
    public function getSponsorTypeFormattedAttribute()
    {
        $types = [
            'individual' => 'Individual',
            'corporate' => 'Corporativo',
            'foundation' => 'Fundación',
            'ngo' => 'ONG',
            'government' => 'Gobierno',
            'international' => 'Internacional',
        ];

        return $types[$this->sponsor_type] ?? $this->sponsor_type;
    }

    /**
     * Accessor para obtener el tipo de contribución formateado
     */
    public function getContributionTypeFormattedAttribute()
    {
        $types = [
            'monetary' => 'Monetaria',
            'materials' => 'Materiales',
            'services' => 'Servicios',
            'volunteer' => 'Voluntariado',
            'mixed' => 'Mixta',
        ];

        return $types[$this->contribution_type] ?? $this->contribution_type;
    }

    /**
     * Accessor para obtener el estado formateado
     */
    public function getStatusFormattedAttribute()
    {
        $statuses = [
            'active' => 'Activo',
            'inactive' => 'Inactivo',
            'pending' => 'Pendiente',
            'suspended' => 'Suspendido',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Accessor para obtener la URL completa del logo
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo_path) {
            return asset('storage/' . $this->logo_path);
        }
        return asset('assets/img/default-sponsor-logo.png');
    }

    /**
     * Verificar si el patrocinador está activo
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Verificar si el patrocinador está destacado
     */
    public function isFeatured()
    {
        return $this->is_featured;
    }

    /**
     * Obtener el total de contribuciones
     */
    public function getTotalContributions()
    {
        return $this->projects()->sum('rel_sponsor_projects.contribution_amount') + $this->contribution_amount;
    }

     public function highlights()
    {
        return $this->hasMany(SponsorHighlight::class, 'sponsor_id');
    }
}


