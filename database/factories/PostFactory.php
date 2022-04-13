<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->slug,
            'user_id' => User::factory(),
            'category_id' => Category::all()->random()->id,
            'title' => $this->faker->sentence,
            'excerpt' => $this->faker->sentence,
            'body' => '<p>'. $this->faker->paragraph . '</p>'
        ];
    }
}
