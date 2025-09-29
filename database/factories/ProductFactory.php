<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(8),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'stock' => $this->faker->numberBetween(1, 99),
            'image' => 'procesador.jpg', // O deja vacío si no tienes imagen real
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
