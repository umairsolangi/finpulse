<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'starts_at',
        'ends_at',
        'gateway',
        'gateway_reference',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Whether this subscription grants active paid access right now.
     * Note: Cancelled subscriptions retain access until their paid ends_at period concludes.
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['active', 'cancelled']) && $this->ends_at->isFuture();
    }

    /**
     * Scope to only active or non-expired subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'cancelled'])
            ->where('ends_at', '>', now());
    }

    /**
     * Scope to subscriptions expiring within a given number of days.
     */
    public function scopeExpiringWithinDays($query, int $days)
    {
        return $query->active()
            ->where('ends_at', '<=', now()->addDays($days));
    }

    /**
     * Scope to subscriptions that have passed their ends_at date but are still marked active.
     */
    public function scopePastDue($query)
    {
        return $query->where('status', 'active')
            ->where('ends_at', '<=', now());
    }
}
