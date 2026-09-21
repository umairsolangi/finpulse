<?php

namespace App\Models;

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\Language;
use App\Enums\SkillLevel;
use Database\Factories\ContentItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentItem extends Model
{
    /** @use HasFactory<ContentItemFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'tier',
        'language',
        'skill_level',
        'body',
        'urdu_body',
        'key_takeaways',
        'quiz_data',
        'video_url',
        'duration_minutes',
        'published_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'type' => ContentType::class,
            'tier' => ContentTier::class,
            'language' => Language::class,
            'skill_level' => SkillLevel::class,
            'published_at' => 'datetime',
            'duration_minutes' => 'integer',
            'key_takeaways' => 'array',
            'quiz_data' => 'array',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(CourseChapter::class, 'content_item_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(ContentBookmark::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ContentView::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ContentComment::class)->latest();
    }

    public function isBookmarkedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }

    public function isCompletedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->views()->where('user_id', $user->id)->whereNotNull('completed_at')->exists();
    }
}
