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
        //title não pode ser duplicado
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

    public function test_update()
    {

        $category = Category::factory()->create();
        $data = [
            'title' => 'Test Update Category',
            'description' => 'Test Updated Category Description',
            'color' => 'blue'
        ];
        //caminho feliz
        $response = $this->put('/categories/'.$category->url, $data);
        $response->assertStatus(200);


        $data = [
            'title' => 'Test Update',
            'description' => 'Test Updated Category Description',
            'color' => 'blue'
        ];
        //Caminho Triste
        $response = $this->put('/categories/fake-category', $data);
        $response->assertStatus(404);

        $response = $this->put('/categories/'.$category->url, []);
        $response->assertStatus(422);
    }

    public function test_delete()
    {
        //Caminho Feliz
        $category = Category::factory()->create();
        $response = $this->delete('/categories/'.$category->url);
        $response->assertStatus(204);

        //Caminho Triste
        $category = Category::factory()->create();
        $response = $this->delete('/categories/122');
        $response->assertStatus(404);
    }

}
