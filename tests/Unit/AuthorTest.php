<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Subject;
use App\Services\AuthorService;
use App\Services\BookService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthorTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_name_more_40_caracteres_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nome não pode ser maior que 40 caracteres');
        $service = app()->make(AuthorService::class);
        $service->save(new Request( [
            'nome' => fake()->paragraph()
        ]));
    }

    public function test_delete_author_has_relation_book(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Author possui livros relacionados');
        $params = $this->makeParamsBook();
        $serviceBook = app()->make(BookService::class);
        $serviceBook->save(new Request( $params));

        $authorId = $params['author_id']->first();

        $serviceAuthor = app()->make(AuthorService::class);
        $serviceAuthor->delete($authorId);
    }

    public function makeParams()
    {
        return [
            'nome' => fake()->word,
        ];
    }

    public function makeParamsBook()
    {
        return [
            'titulo' => fake()->word(),
            'editora' => fake()->word(),
            'edicao' => fake()->numerify,
            'anoPublicacao' => fake()->numerify,
            'valor' => fake()->numerify,
            'subject_id' => Subject::all()->pluck('id'),
            'author_id' => Author::all()->pluck('id')
        ];
    }
}
