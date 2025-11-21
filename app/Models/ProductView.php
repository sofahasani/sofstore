<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductView extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the user who viewed the product
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that was viewed
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope to get views for a specific product
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope to get recent views (last 24 hours)
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDay());
    }

    /**
     * Scope to get views by user or session
     */
    public function scopeForUserOrSession($query, $userId = null, $sessionId = null)
    {
        return $query->where(function($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            }
            if ($sessionId) {
                $q->orWhere('session_id', $sessionId);
            }
        });
    }
}
