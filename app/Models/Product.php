<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'brand',
        'category',
        'price',
        'discount_price',
        'stock',
        'weight',
        'dimensions',
        'tags',
        'condition',
        'warranty',
        'image',
        'is_active',
        'total_sold',
        'rating',
        'review_count',
        'status'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    protected $appends = ['final_price', 'discount_percentage'];

    /**
     * Get reports for the product
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Get reviews for the product
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    /**
     * Get orders for the product
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get product images (gallery)
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get primary image or first image
     */
    public function getPrimaryImageAttribute()
    {
        $primary = $this->images()->where('is_primary', true)->first();
        return $primary ? $primary->image_path : ($this->image ?? null);
    }

    /**
     * Get final price (considering discount)
     */
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->discount_price < $this->price) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Check if product has discount
     */
    public function hasDiscount(): bool
    {
        return $this->discount_price && $this->discount_price < $this->price;
    }

    /**
     * Check if product is in stock
     */
    public function inStock(): bool
    {
        return $this->stock > 0 && $this->is_active;
    }

    /**
     * Check if stock is low
     */
    public function lowStock(int $threshold = 10): bool
    {
        return $this->stock > 0 && $this->stock <= $threshold;
    }

    /**
     * Get average rating from reviews
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total review count
     */
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }
}