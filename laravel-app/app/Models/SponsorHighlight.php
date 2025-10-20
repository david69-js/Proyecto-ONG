<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorHighlight extends Model
{
    use SoftDeletes;

    protected $table = 'ng_sponsor_highlights';
    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true)->whereNotNull('published_at');
    }
}
