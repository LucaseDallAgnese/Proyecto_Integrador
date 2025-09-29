<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'usuario@normal.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        // Ejecutar seeders principales
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            PermissionSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            PaymentSeeder::class,
        ]);
        
        // Asignar el permiso de administrador al usuario admin
        $adminPermission = Permission::where('name', 'acceso-admin-dashboard')->first();
        if ($adminPermission) {
            $admin->permissions()->attach($adminPermission->id);
        }
    }
}