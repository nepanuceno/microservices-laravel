<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $endpoint="/categories";


    /**
     * Get All Categories.
     *
     * @return void
     */
    public function test_get_all_categories()
    {
        Category::factory()->count(6)->create();
        $response = $this->getJson($this->endpoint);
        $response->assertJsonCount(6, 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_category()
    {
        $response = $this->getJson("{$this->endpoint}/fake-category");
        $response->assertStatus(404);
    }

    public function test_get_single_category()
    {
        $category = Category::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$category->url}");
        $response->assertStatus(200);
    }

    public function test_validation_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => '',
            'description' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => 'Categoria 01',
            'description' => 'Descrição da Categoria'
        ]);

        $response->assertStatus(201);
    }

    public function test_update_notfound_category()
    {
        Category::factory()->create();
        $data = [
            'title' => "Categoria 01",
            'description' => "Descrição da Categoria"
        ];

        $response = $this->putJson("{$this->endpoint}/fake-category", $data);
        $response->assertStatus(404);
    }

    public function test_update_category()
    {
        $category = Category::factory()->create();
        $data = [
            'title' => "Categoria 01",
            'description' => "Descrição da Categoria"
        ];

        $response = $this->putJson("{$this->endpoint}/{$category->url}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_not_found_category()
    {
        Category::factory()->create();
        $response = $this->deleteJson("{$this->endpoint}/fake-category");
        $response->assertStatus(404);
    }

    public function test_delete_category()
    {
        $category = Category::factory()->create();
        $response = $this->deleteJson("{$this->endpoint}/{$category->url}");
        $response->assertStatus(204);
    }
}
