<?php

namespace Database\Factories;

use App\Models\ContentItem;
use App\Models\Course;
use App\Models\CourseChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseChapter>
 */
class CourseChapterFactory extends Factory
{
    protected $model = CourseChapter::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'content_item_id' => ContentItem::factory(),
            'title' => fake()->sentence(3),
            'order' => fake()->numberBetween(1, 10),
        ];
    }
}
