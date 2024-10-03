<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    protected $prefixUrl = '/api/authors/';

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

    public function test_delete(): void
    {
        $params = $this->makeParams();
        $response = $this->post($this->prefixUrl, $params);
        $response = $this->delete($this->prefixUrl . json_decode($response->getContent())->data->response->id);
        $response->assertStatus(200);
    }

    public function makeParams()
    {
        return [
            'nome' => fake()->word,
        ];
    }
}
