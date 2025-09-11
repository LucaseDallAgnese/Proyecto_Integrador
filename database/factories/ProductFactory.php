<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word() . ' ' . fake()->randomElement(['Pro', 'Max', 'Lite', 'Plus', 'Edición Limitada']),
            'description' => fake()->sentence(8),
            'price' => fake()->randomFloat(2, 10, 500),
            'stock' => fake()->numberBetween(1, 99),
            'image' => 'products/' . fake()->uuid() . '.jpg',
            'category_id' => null, // O puedes asignar una categoría existente si tienes
        ];
    }
}
