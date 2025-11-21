<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'reason',
        'description',
        'status',
        'reporter_ip',
        'reviewed_at',
        'reviewed_by',
        'admin_notes',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the product that was reported
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who reported
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who reviewed
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get reason label
     */
    public function getReasonLabelAttribute(): string
    {
        $labels = [
            'fake' => 'Produk Palsu/Tiruan',
            'scam' => 'Penipuan',
            'inappropriate' => 'Konten Tidak Pantas',
            'prohibited' => 'Barang Terlarang',
            'misleading' => 'Informasi Menyesatkan',
            'copyright' => 'Pelanggaran Hak Cipta',
            'other' => 'Lainnya',
        ];

        return $labels[$this->reason] ?? $this->reason;
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending' => 'Menunggu',
            'reviewed' => 'Ditinjau',
            'resolved' => 'Selesai',
            'dismissed' => 'Ditolak',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending' => 'orange',
            'reviewed' => 'blue',
            'resolved' => 'green',
            'dismissed' => 'gray',
        ];

        return $colors[$this->status] ?? 'gray';
    }
}
