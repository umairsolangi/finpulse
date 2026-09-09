<?php

namespace App\Models;

use Database\Factories\CourseChapterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
