<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonorHighlight extends Model
{
    use SoftDeletes;

    protected $table = 'ng_donor_highlights';
    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true)->whereNotNull('published_at');
    }

    // helper para skills en array
    public function getSkillsArrayAttribute()
    {
        if (!$this->skills) return [];
        return array_values(array_filter(array_map('trim', explode(',', $this->skills))));
    }
}
