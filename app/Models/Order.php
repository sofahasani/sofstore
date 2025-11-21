<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref_number',
        'user_id',
        'product_id',
        'product_name',
        'product_description',
        'product_price',
        'product_image',
        'quantity',
        'total_amount',
        'customer_email',
        'address',
        'locality',
        'city',
        'state',
        'pincode',
        'address_type',
        'payment_method',
        'cardholder_name',
        'card_number',
        'payment_time',
        'status',
        'tracking_status',
        'tracking_notes',
        'status_updated_at',
    ];

    protected $casts = [
        'payment_time' => 'datetime',
        'status_updated_at' => 'datetime',
        'product_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the order.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the reviews for this order.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope to filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }
}
