<?php

namespace Database\Factories;

use App\Enums\PostCategory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category' => fake()->randomElement(PostCategory::cases()),
            'body' => fake()->paragraph(),
        ];
    }
}
