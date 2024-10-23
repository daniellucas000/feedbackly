<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $random_seed = uniqid();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'profile' => " https://api.dicebear.com/9.x/adventurer/svg?seed=Avery&randomizeIds=true",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    /**
     *
     * @return static
     */
}
