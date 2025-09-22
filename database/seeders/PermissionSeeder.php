<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpiar la tabla antes de insertar
        DB::table('permissions')->delete();
        
        // Crear los permisos
        $permissions = [
            ['name' => 'acceso-admin-dashboard'],
            // Puedes agregar más permisos aquí en el futuro
            // ['name' => 'editar-productos'],
            // ['name' => 'eliminar-usuarios'],
        ];

        // Insertar los permisos en la tabla
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
