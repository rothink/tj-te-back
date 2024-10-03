<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookSubjectsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->first() ,
            'subject_id' => Subject::inRandomOrder()->first(),
        ];
    }
}
