<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Beneficiary extends Model
{
    use HasFactory;

    protected $table = 'ng_beneficiaries';

    protected $fillable = [
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
     * Relación con el proyecto
     */
    //public function project()
    //{
    //    return $this->belongsTo(Project::class, 'project_id');
    //}
}
