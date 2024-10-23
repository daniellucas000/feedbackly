<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'place' => fake()->company(),
            'rating' => fake()->numberBetween(1, 5),
            'categorie' => fake()->randomElement(['Restaurante', 'Loja', 'Serviço', 'Café', 'Entretenimento']),
            'image' => 'https://picsum.photos/330/160',
            'comment' => fake()->sentence(),
            'city' => fake()->city(),
            'user_id' => User::inRandomOrder()->value('id'),
        ];
    }
}
