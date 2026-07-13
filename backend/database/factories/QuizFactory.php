<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'user_id' => \App\Models\User::factory(),
            'is_active' => true,
        ];
    }
}