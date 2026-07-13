<?php

namespace Database\Factories;

use App\Models\Discussion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Discussion>
 */
class DiscussionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'user_id' => \App\Models\User::factory(),
            'category' => $this->faker->word,
            'is_active' => true,
            'views' => rand(0, 100),
        ];
    }
}