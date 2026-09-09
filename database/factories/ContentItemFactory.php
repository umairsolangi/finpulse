<?php

namespace Database\Factories;

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Models\ContentItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ContentItem>
 */
class ContentItemFactory extends Factory
{
    protected $model = ContentItem::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->randomNumber(4),
            'type' => fake()->randomElement(ContentType::cases()),
            'tier' => fake()->randomElement(ContentTier::cases()),
            'language' => Language::ENGLISH,
            'skill_level' => fake()->randomElement(SkillLevel::cases()),
            'body' => fake()->paragraphs(3, true),
            'video_url' => fake()->optional()->url(),
            'duration_minutes' => fake()->numberBetween(5, 120),
            'published_at' => now(),
            'created_by' => User::factory(),
        ];
    }
}
