<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Milestone 2 — Block User.
 */
class UserBlock extends Model
{
    protected $guarded = [];

    protected $casts = [
        'blocker_id' => 'integer',
        'blocked_id' => 'integer',
    ];

    public function blocker()
    {
        return $this->belongsTo(User::class, 'blocker_id');
    }

    public function blocked()
    {
        return $this->belongsTo(User::class, 'blocked_id');
    }

    /**
     * True when there is a block in EITHER direction between two users
     * (a blocked user can't message the blocker and vice-versa).
     */
    public static function blockedBetween($a, $b): bool
    {
        return self::where(function ($q) use ($a, $b) {
            $q->where('blocker_id', $a)->where('blocked_id', $b);
        })->orWhere(function ($q) use ($a, $b) {
            $q->where('blocker_id', $b)->where('blocked_id', $a);
        })->exists();
    }

    /** IDs the given user has blocked OR been blocked by (to hide from chat list). */
    public static function relatedBlockedIds($userId): array
    {
        $blocked = self::where('blocker_id', $userId)->pluck('blocked_id');
        $blockedBy = self::where('blocked_id', $userId)->pluck('blocker_id');
        return $blocked->merge($blockedBy)->unique()->values()->all();
    }
}
