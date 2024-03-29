<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->word(),
            'editora' => fake()->word(),
            'edicao' => fake()->numerify,
            'anoPublicacao' => 19 . random_int(0,9) . random_int(0,9),
            'valor' => fake()->randomDigit()
        ];
    }
}
