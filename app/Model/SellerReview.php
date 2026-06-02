<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Milestone 3 — Seller Rating System.
 * A star rating (1–5) + written review left by a customer for a seller (ad poster).
 */
class SellerReview extends Model
{
    protected $guarded = [];

    protected $casts = [
        'seller_id'   => 'integer',
        'customer_id' => 'integer',
        'rating'      => 'integer',
        'status'      => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    /** In-request memo so listing pages don't re-query the same seller per card. */
    private static array $summaryCache = [];

    /** Reset the in-request memo (used for test isolation; harmless in production). */
    public static function flushSummaryCache(): void
    {
        self::$summaryCache = [];
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Average rating + review count for a seller, memoised for the request.
     * @return array{avg: float, count: int}
     */
    public static function summaryFor($sellerId): array
    {
        $sellerId = (int) $sellerId;
        if (!$sellerId) {
            return ['avg' => 0.0, 'count' => 0];
        }
        if (isset(self::$summaryCache[$sellerId])) {
            return self::$summaryCache[$sellerId];
        }

        $row = self::where('seller_id', $sellerId)->where('status', 1)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
            ->first();

        return self::$summaryCache[$sellerId] = [
            'avg'   => round((float) ($row->avg_rating ?? 0), 1),
            'count' => (int) ($row->total ?? 0),
        ];
    }
}
