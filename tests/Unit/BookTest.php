<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Subject;
use App\Services\BookService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tests\TestCase;

class BookTest extends TestCase
{

    public function setUp() :void
    {
        parent::setUp();
    }

    public function test_livro_ano_futuro_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não é permitido livros do futuro');
        $params = $this->makeParams();
        $serviceBook = app()->make(BookService::class);
        $serviceBook->save(new Request( $params));
    }

    public function test_assunto_nao_existe_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Assunto não existe');
        $params = $this->makeParams();
        $params['anoPublicacao'] = 2020;
        $params['subject_id'] = [999];
        $serviceBook = app()->make(BookService::class);
        $serviceBook->save(new Request( $params));
    }

    public function test_author_nao_existe_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Autor não existe');
        $params = $this->makeParams();
        $params['anoPublicacao'] = 2020;
        $params['author_id'] = [999];

        $serviceBook = app()->make(BookService::class);
        $serviceBook->save(new Request( $params));
    }

    public function makeParams()
    {
        $params = [
            'titulo' => fake()->word(),
            'editora' => fake()->word(),
            'edicao' => fake()->numerify(),
            'anoPublicacao' => Carbon::now()->year + 10,
            'valor' => fake()->numerify(),
            'subject_id' => Subject::all()->first()->pluck('id'),
            'author_id' => Author::all()->first()->pluck('id')
        ];
        return $params;
    }
}
