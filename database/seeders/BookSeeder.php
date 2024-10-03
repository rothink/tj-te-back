<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookAuthors;
use App\Models\BookSubjects;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::factory()
            ->count(20)
            ->create()
            ->each(function ($book) {
                BookSubjects::factory()
                    ->count(1)
                    ->create();
                BookAuthors::factory()
                    ->count(1)
                    ->create();
            });
    }
}
