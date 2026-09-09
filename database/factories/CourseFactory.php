<?php

namespace Database\Factories;

use App\Enums\ContentTier;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->randomNumber(4),
            'description' => fake()->paragraph(),
            'tier' => fake()->randomElement(ContentTier::cases()),
            'language' => Language::ENGLISH,
            'skill_level' => fake()->randomElement(SkillLevel::cases()),
            'created_by' => User::factory(),
        ];
    }
}
