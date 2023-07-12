<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    public function test_create()
    {
        //Caminho Feliz
        $response = $this->post('/categories', [
            'title' => 'Test Category',
            'description' => 'Test Category Description',
            'color' => 'red',
        ]);

        $response->assertStatus(201);
        $response->assertJson(['data' => [
            'id' => 1,
            'title' => 'Test Category',
            'description' => 'Test Category Description',
            'color' => 'red',
            'slug' => 'test-category',
        ]]);

        //Caminho Triste
        $response = $this->post('/categories', [
            'title' => 'Test Category',
            'description' => 'Test Category Description',
            'color' => 'red',
        ]);
        $response->assertStatus(422);

    }

    /**
     * A basic feature test Get all category.
     *
     * @return void
     */
    public function test_all()
    {
        //Caminho Feliz
        Category::factory()->count(10)->create();
        $response = $this->get('/categories');
        $response->assertStatus(200);
        $this->assertNotEmpty($response['data']);
        $response->assertJsonCount(10, 'data');

        //Caminho Triste
        $response = $this->get('/categoriess');
        $response->assertStatus(404);
    }

}
