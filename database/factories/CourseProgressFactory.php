<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseProgress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseProgress>
 */
class CourseProgressFactory extends Factory
{
    protected $model = CourseProgress::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'chapter_id' => CourseChapter::factory(),
            'completed_at' => now(),
        ];
    }
}
