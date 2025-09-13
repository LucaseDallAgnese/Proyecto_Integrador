<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

          $this->call([
        CategorySeeder::class, 
        ProductSeeder::class,
    ]);

        $this->call([
            ProductSeeder::class,
            // Otros seeders aquí...
        ]);
    }
}