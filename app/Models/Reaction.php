<?php

namespace App\Models;

use App\Services\ActivityScoreService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected static function booted(): void
    {
        static::created(function (Reaction $reaction): void {
            if ($reaction->user) {
                app(ActivityScoreService::class)->recordActivity($reaction->user, 'reaction_given');
            }
        });

        // NOTE: Activity score is intentionally NOT decremented when a reaction is deleted (toggled off).
        // Activity score reflects historical participation, not current state.
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
