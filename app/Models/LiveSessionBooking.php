<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveSessionBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_session_id',
        'user_id',
        'booked_at',
        'attended',
    ];

    protected function casts(): array
    {
        return [
            'booked_at' => 'datetime',
            'attended' => 'boolean',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(LiveSession::class, 'live_session_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
