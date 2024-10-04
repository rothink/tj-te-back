<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Subject;
use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\SubjectService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tests\TestCase;

class SubjectTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_description_more_20_caracteres_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Descrição não pode ser maior que 20 caracteres');
        $service = app()->make(SubjectService::class);
        $service->save(new Request( [
            'descricao' => fake()->paragraph()
        ]));
    }

    public function test_delete_author_has_relation_book(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Assunto possui livros relacionados');
        $params = $this->makeParamsBook();
        $serviceBook = app()->make(BookService::class);
        $serviceBook->save(new Request( $params));

        $subjectId = $params['subject_id']->first();

        $serviceAuthor = app()->make(SubjectService::class);
        $serviceAuthor->delete($subjectId);
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
