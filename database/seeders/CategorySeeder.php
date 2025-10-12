<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creación de categorías de ejemplo
        Category::create(['name' => 'Procesadores']);
        Category::create(['name' => 'Tarjetas Gráficas']);
        Category::create(['name' => 'Memorias RAM']);
        Category::create(['name' => 'Almacenamiento']);
        Category::create(['name' => 'Placas Base']);
        Category::create(['name' => 'Fuentes de Poder']);
        Category::create(['name' => 'General']); // <-- AQUÍ ESTÁ
    }
}