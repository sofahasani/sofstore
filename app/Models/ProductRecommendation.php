<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRecommendation extends Model
{
    protected $fillable = [
        'product_id',
        'recommended_product_id',
        'type',
        'score',
        'count',
    ];

    /**
     * Get the source product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the recommended product
     */
    public function recommendedProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'recommended_product_id');
    }

    /**
     * Scope to get recommendations for a product
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope to get recommendations by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to get top recommendations
     */
    public function scopeTopScored($query, $limit = 4)
    {
        return $query->orderByDesc('score')->limit($limit);
    }
}
