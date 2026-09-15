<?php

namespace App\Models;

use App\Notifications\NewChapterPublished;
use Database\Factories\CourseChapterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Notification;

class CourseChapter extends Model
{
    /** @use HasFactory<CourseChapterFactory> */
    use HasFactory;

    protected $fillable = [
        'course_id',
        'content_item_id',
        'title',
        'order',
    ];

    protected static function booted(): void
    {
        static::created(function (CourseChapter $chapter) {
            $chapter->loadMissing('course');
            if (! $chapter->course) {
                return;
            }

            $enrolledUserIds = CourseProgress::where('course_id', $chapter->course_id)
                ->distinct()
                ->pluck('user_id');

            $users = User::whereIn('id', $enrolledUserIds)->get();
            if ($users->isNotEmpty()) {
                Notification::send($users, new NewChapterPublished($chapter->course, $chapter));
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function contentItem(): BelongsTo
    {
        return $this->belongsTo(ContentItem::class, 'content_item_id');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(CourseProgress::class, 'chapter_id');
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class, 'course_chapter_id');
    }
}
