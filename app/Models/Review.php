<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'comment',
        'reviewer_name',
        'is_verified_purchase',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Get the user that wrote the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product being reviewed
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order associated with the review
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get star rating as HTML
     */
    public function getStarRatingAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '⭐' : '☆';
        }
        return $stars;
    }
}
