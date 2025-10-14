<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Beneficiary extends Model
{
    use HasFactory;

    protected $table = 'ng_beneficiaries';

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'gender',
        'address',
        'phone',
        'email',
        'beneficiary_type',
        'status',
        'project_id',
        'notes',
    ];
    
    /**
     * Relación con el usuario
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
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Accessor para obtener el género formateado
     */
    public function getGenderFormattedAttribute()
    {
        $genders = [
            'Male' => 'Masculino',
            'Female' => 'Femenino',
            'Other' => 'Otro',
        ];

        return $genders[$this->gender] ?? $this->gender;
    }

    /**
     * Accessor para obtener el tipo de beneficiario formateado
     */
    public function getBeneficiaryTypeFormattedAttribute()
    {
        $types = [
            'Person' => 'Persona',
            'Family' => 'Familia',
            'Community' => 'Comunidad',
        ];

        return $types[$this->beneficiary_type] ?? $this->beneficiary_type;
    }

    /**
     * Accessor para obtener el estado formateado
     */
    public function getStatusFormattedAttribute()
    {
        $statuses = [
            'Active' => 'Activo',
            'Inactive' => 'Inactivo',
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}
