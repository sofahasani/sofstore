<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get the user that owns the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get subtotal for this cart item
     */
    public function getSubtotalAttribute()
    {
        return $this->product->final_price * $this->quantity;
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp' . number_format($this->subtotal, 0, ',', '.');
    }
}
