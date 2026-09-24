<?php

namespace Database\Factories;

use App\Enums\BatchStatus;
use App\Models\Batch;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Batch>
 */
class BatchFactory extends Factory
{
    protected $model = Batch::class;

    public function definition(): array
    {
        return [
            'name' => 'Batch '.fake()->unique()->numberBetween(1, 999),
            'course_id' => Course::factory(),
            'created_by' => User::factory(),
            'start_date' => fake()->optional()->dateTimeBetween('now', '+3 months'),
            'status' => fake()->randomElement(BatchStatus::cases()),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BatchStatus::ACTIVE,
        ]);
    }

    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BatchStatus::UPCOMING,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BatchStatus::COMPLETED,
        ]);
    }
}
