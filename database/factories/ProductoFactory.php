<?php

namespace Database\Factories;

use App\Models\Producto; // Importa tu modelo Producto
use Illuminate\Database\Eloquent\Factories\Factory;


//@extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
class ProductoFactory extends Factory
{
        
// @return array<string, mixed>
     
    public function definition(): array
    {
        return [
            'nombre' => fake()->word() . ' ' . fake()->randomElement(['Pro', 'Max', 'Lite', 'Plus', 'Edición Limitada']), // Genera un nombre de producto aleatorio [Apunte - Seeders y Factories.pdf, 121]
            'descripcion' => fake()->sentence(8), // Genera una descripción de 8 palabras [Apunte - Seeders y Factories.pdf, 121]
            'precio' => fake()->randomFloat(2, 10, 500), // Precio con 2 decimales, entre 10 y 500 [Apunte - Seeders y Factories.pdf, 120]
            'stock' => fake()->randomNumber(2, false), // Un número aleatorio de 2 dígitos para el stock [Apunte - Seeders y Factories.pdf, 120]
            'imagen' => 'products/' . fake()->uuid() . '.jpg', // Simula una ruta de imagen única [Apunte - Seeders y Factories.pdf, 122]
        ];
    }
}
