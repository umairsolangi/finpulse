<?php

namespace App\Models;

use App\Services\ActivityScoreService;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'body',
    ];

    protected static function booted(): void
    {
        static::created(function (Comment $comment): void {
            if ($comment->user) {
                app(ActivityScoreService::class)->recordActivity($comment->user, 'comment_created');
            }
        });

        // NOTE: Activity score is intentionally NOT decremented when a comment is deleted.
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
