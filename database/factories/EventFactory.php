<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title= $this->faker->sentence(rand(4, 8));
        return [
            'title' =>$title,
            'slug' => str($title)->slug(),
            'content' => $this->faker->paragraph(rand(1,4)),
            'premium' => $this->faker->boolean(25),
            'starts_at' => $this->faker->dateTimeBetween('now', '+2 months'),
            'ends_at' => $this->faker->dateTimeBetween('+3 months', '+4 months'),
            'image' => $this->faker->image(),
        ];
    }
}
