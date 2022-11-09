<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CompanyTest extends TestCase
{
    protected $endpoint="/companies";


    /**
     * Get All companies.
     *
     * @return void
     */
    public function test_get_all_companies()
    {
        Company::factory()->count(6)->create();
        $response = $this->getJson($this->endpoint);
        $response->assertJsonCount(6, 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_Company()
    {
        $response = $this->getJson("{$this->endpoint}/fake-Company");
        $response->assertStatus(404);
    }

    public function test_get_single_Company()
    {
        $company = Company::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$company->uuid}");
        $response->assertStatus(200);
    }

    public function test_validation_store_Company()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => '',
            'description' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_store_Company()
    {
        $category = Category::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'category_id' =>  $category->id,
            'name' => 'Descrição da Company',
            'email' => 'paulo.torres@mail.com',
            'whatsapp' => '63984425473'

        ]);

        $response->assertStatus(201);
    }

    public function test_update_notfound_company()
    {
        $category = Category::factory()->create();
        $data = [
            'category_id' =>  $category->id,
            'name' => "Company 01",
            'email' => 'paulo.torres@mail.com',
            'whatsapp' => '36992077258'
        ];

        $response = $this->putJson("{$this->endpoint}/fake-company-uuid", $data);

        $response->assertStatus(404);
    }

    public function test_update_company()
    {
        $category = Category::factory()->create();
        $company = Company::factory()->create();
        $data = [
            'category_id' =>  $category->id,
            'name' => "Company 01",
            'email' => 'paulo.torres@mail.com',
            'whatsapp' => '36992077258'
        ];
        $response = $this->putJson("{$this->endpoint}/{$company->uuid}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_not_found_Company()
    {
        Company::factory()->create();
        $response = $this->deleteJson("{$this->endpoint}/fake-Company");
        $response->assertStatus(404);
    }

    public function test_delete_Company()
    {
        $company = Company::factory()->create();
        $response = $this->deleteJson("{$this->endpoint}/{$company->uuid}");
        $response->assertStatus(204);
    }
}
