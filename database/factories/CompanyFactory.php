<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory()->create(),
            'name' => $this->faker->unique()->name(),
            'whatsapp' => $this->faker->unique()->numberBetween('63981000000','63999999999'),
            'email' => $this->faker->unique()->email(),
        ];
    }
}
