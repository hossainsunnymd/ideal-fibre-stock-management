<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'category_id' => 1,
            'unit' => 1,
            'unit_type' => 'pc',
            'minimum_stock' => 1,
            'parts_no' => fake()->name(),
            'rack_no' => fake()->name(),
            'column_no' => fake()->name(),
            'row_no' => fake()->name(),

        ];
    }
}
