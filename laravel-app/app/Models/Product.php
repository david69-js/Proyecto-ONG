<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'category',
        'subcategory',
        'tags',
        'stock_quantity',
        'stock_status',
        'manage_stock',
        'cost_price',
        'suggested_price',
        'currency',
        'weight',
        'length',
        'width',
        'height',
        'main_image',
        'gallery_images',
        'is_active',
        'is_featured',
        'is_digital',
        'requires_shipping',
        'ngo_notes',
        'donation_source',
        'received_date',
        'condition',
        'specifications',
        'usage_instructions',
        'care_instructions',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tags' => 'array',
        'gallery_images' => 'array',
        'specifications' => 'array',
        'manage_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_digital' => 'boolean',
        'requires_shipping' => 'boolean',
        'cost_price' => 'decimal:2',
        'suggested_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'received_date' => 'date',
    ];

    protected $attributes = [
        'currency' => 'GTQ',
        'stock_status' => 'in_stock',
        'condition' => 'new',
    ];

    /**
     * Relación con el usuario que creó el producto
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con el usuario que actualizó el producto
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Boot method para generar slug automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PROD-' . strtoupper(uniqid());
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Scopes para filtros
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock_status', 'out_of_stock');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeBySubcategory($query, $subcategory)
    {
        return $query->where('subcategory', $subcategory);
    }

    public function scopeDigital($query)
    {
        return $query->where('is_digital', true);
    }

    public function scopePhysical($query)
    {
        return $query->where('is_digital', false);
    }

    public function scopeByCondition($query, $condition)
    {
<<<<<<< HEAD
        return $query->whereRaw('`condition` = ?', [$condition]);
=======
        return $query->where('condition', $condition);
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%')
              ->orWhere('sku', 'like', '%' . $search . '%')
              ->orWhere('tags', 'like', '%' . $search . '%');
        });
    }

    /**
     * Accessor para la URL de la imagen principal
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->main_image) {
            return asset('storage/' . $this->main_image);
        }
        return asset('assets/img/no-image.png');
    }

    /**
     * Accessor para las URLs de la galería
     */
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery_images) {
            return [];
        }

        return collect($this->gallery_images)->map(function ($image) {
            return asset('storage/' . $image);
        })->toArray();
    }

    /**
     * Accessor para el precio formateado
     */
    public function getFormattedSuggestedPriceAttribute()
    {
        if (!$this->suggested_price) {
            return 'N/A';
        }

        $symbols = [
            'GTQ' => 'Q',
            'USD' => '$',
            'EUR' => '€',
            'MXN' => '$',
        ];

        $symbol = $symbols[$this->currency] ?? $this->currency;
        return $symbol . number_format($this->suggested_price, 2);
    }

    /**
     * Accessor para el precio de costo formateado
     */
    public function getFormattedCostPriceAttribute()
    {
        if (!$this->cost_price) {
            return 'N/A';
        }

        $symbols = [
            'GTQ' => 'Q',
            'USD' => '$',
            'EUR' => '€',
            'MXN' => '$',
        ];

        $symbol = $symbols[$this->currency] ?? $this->currency;
        return $symbol . number_format($this->cost_price, 2);
    }

    /**
     * Accessor para el estado del stock formateado
     */
    public function getStockStatusFormattedAttribute()
    {
        $statuses = [
            'in_stock' => 'En Stock',
            'out_of_stock' => 'Agotado',
            'low_stock' => 'Stock Bajo',
            'discontinued' => 'Descontinuado',
        ];

        return $statuses[$this->stock_status] ?? $this->stock_status;
    }

    /**
     * Accessor para la condición formateada
     */
    public function getConditionFormattedAttribute()
    {
        $conditions = [
            'new' => 'Nuevo',
            'like_new' => 'Como Nuevo',
            'good' => 'Bueno',
            'fair' => 'Regular',
            'poor' => 'Malo',
        ];

        return $conditions[$this->condition] ?? $this->condition;
    }

    /**
     * Verificar si el producto está en stock
     */
    public function isInStock()
    {
        return $this->stock_status === 'in_stock' && $this->stock_quantity > 0;
    }

    /**
     * Verificar si el producto está agotado
     */
    public function isOutOfStock()
    {
        return $this->stock_status === 'out_of_stock' || $this->stock_quantity <= 0;
    }

    /**
     * Verificar si el producto es digital
     */
    public function isDigital()
    {
        return $this->is_digital;
    }

    /**
     * Verificar si el producto es físico
     */
    public function isPhysical()
    {
        return !$this->is_digital;
    }

    /**
     * Obtener dimensiones formateadas
     */
    public function getFormattedDimensionsAttribute()
    {
        if (!$this->length || !$this->width || !$this->height) {
            return 'N/A';
        }

        return $this->length . ' x ' . $this->width . ' x ' . $this->height . ' cm';
    }

    /**
     * Obtener peso formateado
     */
    public function getFormattedWeightAttribute()
    {
        if (!$this->weight) {
            return 'N/A';
        }

        return $this->weight . ' kg';
    }

    /**
     * Obtener estadísticas de productos
     */
    public static function getStatistics($filters = [])
    {
        $query = self::query();

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return [
            'total_products' => $query->count(),
            'active_products' => (clone $query)->active()->count(),
            'featured_products' => (clone $query)->featured()->count(),
            'in_stock_products' => (clone $query)->inStock()->count(),
            'out_of_stock_products' => (clone $query)->outOfStock()->count(),
            'digital_products' => (clone $query)->digital()->count(),
            'physical_products' => (clone $query)->physical()->count(),
        ];
    }
}
