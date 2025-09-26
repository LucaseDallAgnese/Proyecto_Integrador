<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear el usuario administrador
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'usuario@normal.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Ejecutar los seeders principales
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            PermissionSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            AddressSeeder::class,
            PaymentSeeder::class,
        ]);
        
        // 3. Asignar el permiso de administrador al usuario
        $adminPermission = Permission::where('name', 'acceso-admin-dashboard')->first();

        if ($adminPermission) {
            $admin->permissions()->attach($adminPermission->id);
        }
    }
}