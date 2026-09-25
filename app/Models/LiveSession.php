<?php

namespace App\Models;

use App\Enums\ContentTier;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'host_id',
        'scheduled_at',
        'ended_at',
        'duration_minutes',
        'tier',
        'meeting_url',
        'agora_channel_name',
        'max_attendees',
    ];

    protected static function booted(): void
    {
        static::creating(function (LiveSession $session) {
            if (empty($session->agora_channel_name)) {
                $session->agora_channel_name = static::generateChannelName($session->title ?? 'live-session');
            }
        });
    }

    /**
     * Generate a unique, non-guessable Agora channel name.
     */
    public static function generateChannelName(string $title): string
    {
        $cleanTitle = Str::slug(Str::limit($title, 20, ''));
        $prefix = $cleanTitle !== '' ? $cleanTitle : 'session';
        $random = Str::lower(Str::random(12));

        return "fp-{$prefix}-{$random}";
    }

    /**
     * Check if a host has an overlapping live session in a given time window.
     */
    public static function hostHasOverlap(int $hostId, CarbonInterface $start, int $durationMinutes, ?int $ignoreSessionId = null): bool
    {
        $end = $start->copy()->addMinutes($durationMinutes);
        $driver = DB::connection()->getDriverName();
        $overlapRaw = $driver === 'sqlite'
            ? "datetime(scheduled_at, '+' || duration_minutes || ' minutes') > ?"
            : 'DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) > ?';

        return static::where('host_id', $hostId)
            ->whereNull('ended_at')
            ->when($ignoreSessionId, fn ($q) => $q->where('id', '!=', $ignoreSessionId))
            ->where(function ($query) use ($start, $end, $overlapRaw) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('scheduled_at', '>=', $start)
                        ->where('scheduled_at', '<', $end);
                })->orWhere(function ($q) use ($start, $overlapRaw) {
                    $q->where('scheduled_at', '<=', $start)
                        ->whereRaw($overlapRaw, [$start]);
                });
            })
            ->exists();
    }

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'ended_at' => 'datetime',
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
     * Whether the session has already been ended.
     */
    public function isEnded(): bool
    {
        return $this->ended_at !== null;
    }

    /**
     * Whether users can still book/join this session (it has not ended yet).
     */
    public function isBookable(): bool
    {
        if ($this->isEnded()) {
            return false;
        }

        $windowEnd = $this->scheduled_at->copy()->addMinutes($this->duration_minutes);

        return now()->isBefore($windowEnd);
    }

    /**
     * Whether the session is currently broadcasting live.
     */
    public function isLiveNow(): bool
    {
        if ($this->isEnded()) {
            return false;
        }

        $windowEnd = $this->scheduled_at->copy()->addMinutes($this->duration_minutes);

        return now()->between($this->scheduled_at, $windowEnd);
    }

    /**
     * Whether the join link should be active (10 minutes before start through end).
     */
    public function isJoinable(): bool
    {
        if ($this->isEnded()) {
            return false;
        }

        $windowStart = $this->scheduled_at->copy()->subMinutes(10);
        $windowEnd = $this->scheduled_at->copy()->addMinutes($this->duration_minutes);

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
        $driver = DB::connection()->getDriverName();
        $endRaw = $driver === 'sqlite'
            ? "datetime(scheduled_at, '+' || duration_minutes || ' minutes')"
            : 'DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE)';

        return $query->whereNull('ended_at')
            ->whereRaw("{$endRaw} >= ?", [now()])
            ->orderBy('scheduled_at');
    }
}
