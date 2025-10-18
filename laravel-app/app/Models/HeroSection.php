<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $table = 'hero_sections';

    protected $fillable = [
        'subtitle',
        'title',
        'description',
        'button_primary_text',
        'button_primary_link',
        'button_secondary_text',
        'button_secondary_link',
        'anios_servicio',
        'viviendas_construidas',
        'familias_beneficiadas',
        'image_main',
        'image_badge_text',
        'image_badge_subtext',
    ];
}
