<?php

namespace App\Models;

use App\Enums\ContentTier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'host_id',
        'scheduled_at',
        'duration_minutes',
        'tier',
        'meeting_url',
        'max_attendees',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'duration_minutes' => 'integer',
            'tier' => ContentTier::class,
            'max_attendees' => 'integer',
        ];
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(LiveSessionBooking::class);
    }

    /**
     * Whether users can still book this session (it's in the future).
     */
    public function isBookable(): bool
    {
        return $this->scheduled_at->isFuture();
    }

    /**
     * Whether the join link should be active (10 minutes before start through end).
     */
    public function isJoinable(): bool
    {
        $windowStart = $this->scheduled_at->subMinutes(10);
        $windowEnd = $this->scheduled_at->addMinutes($this->duration_minutes);

        return now()->between($windowStart, $windowEnd);
    }

    /**
     * Whether the session has reached its attendee capacity.
     */
    public function isFull(): bool
    {
        if ($this->type === 'one_on_one') {
            return $this->bookings()->count() >= 1;
        }

        if ($this->max_attendees) {
            return $this->bookings()->count() >= $this->max_attendees;
        }

        return false;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at');
    }
}
