<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectPhaseImage extends Model
{
    protected $fillable = [
        'project_id',
        'fase',
        'image_path',
        'original_name',
        'mime_type',
        'file_size',
        'description'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
