<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    protected $prefixUrl = '/api/books/';

    /**
     * A basic feature test example.
     */
    public function test_list(): void
    {
        $response = $this->get($this->prefixUrl);
        $response->assertStatus(200);
    }

    public function test_create(): void
    {
        $params = $this->makeParams();
        $response = $this->post($this->prefixUrl, $params);
        $response->assertStatus(201);
    }

    public function test_update(): void
    {
        $params = $this->makeParams();
        $response = $this->post($this->prefixUrl, $params);
        $response = $this->put($this->prefixUrl . json_decode($response->getContent())->data->response->id, $params);
        $response->assertStatus(200);
    }

    public function test_find(): void
    {
        $params = $this->makeParams();
        $response = $this->post($this->prefixUrl, $params);
        $response = $this->get($this->prefixUrl . json_decode($response->getContent())->data->response->id);
        $response->assertStatus(200);
    }

    public function test_find_exception(): void
    {
        $params = $this->makeParams();
        $this->post($this->prefixUrl, $params);
        $response = $this->get($this->prefixUrl . 9999999999999999);
        $response->assertStatus(422);
        $response->assertContent('{"status":"error","message":"Objeto n\u00e3o encontrado no database"}');
    }

    public function test_delete(): void
    {
        $params = $this->makeParams();
        $response = $this->post($this->prefixUrl, $params);
        $response = $this->delete($this->prefixUrl . json_decode($response->getContent())->data->response->id);
        $response->assertStatus(200);
    }

    public function test_can_not_create_a_book_with_year_after_now(): void
    {
        $params = $this->makeParams();
        $params['anoPublicacao'] = Carbon::now()->addYear(1)->format('Y');
        $response = $this->post($this->prefixUrl, $params);
        $response->assertStatus(422);
        $response->assertContent('{"status":"error","message":"N\u00e3o \u00e9 permitido livros do futuro"}');
    }

    public function makeParams()
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
