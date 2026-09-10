<?php

namespace App\Models;

use App\Enums\PostCategory;
use App\Services\ActivityScoreService;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'body',
    ];

    protected function casts(): array
    {
        return [
            'category' => PostCategory::class,
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Post $post): void {
            if ($post->user) {
                app(ActivityScoreService::class)->recordActivity($post->user, 'post_created');
            }
        });

        // NOTE: Activity score is intentionally NOT decremented when a post is deleted.
        // Activity score reflects historical participation, not current state.
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class, 'post_id');
    }
}
