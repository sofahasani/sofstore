<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceAlert extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'original_price',
        'current_price',
        'discount_percentage',
        'is_notified',
        'notified_at',
    ];

    protected $casts = [
        'is_notified' => 'boolean',
        'notified_at' => 'datetime',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope to get unnotified alerts
     */
    public function scopeUnnotified($query)
    {
        return $query->where('is_notified', false);
    }

    /**
     * Scope to get alerts with significant discount
     */
    public function scopeSignificantDiscount($query, $minPercentage = 5)
    {
        return $query->where('discount_percentage', '>=', $minPercentage);
    }
}
