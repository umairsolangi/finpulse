<?php

namespace App\Models;

use App\Enums\ContentTier;
use App\Enums\Language;
use App\Enums\SkillLevel;
use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'tier',
        'language',
        'skill_level',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tier' => ContentTier::class,
            'language' => Language::class,
            'skill_level' => SkillLevel::class,
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(CourseChapter::class, 'course_id');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(CourseProgress::class, 'course_id');
    }
}
