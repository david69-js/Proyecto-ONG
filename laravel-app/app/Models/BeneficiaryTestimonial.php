<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeneficiaryTestimonial extends Model
{
    use SoftDeletes;

    protected $table = 'ng_beneficiary_testimonials';
    protected $guarded = [];
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true)->whereNotNull('published_at');
    }
}
