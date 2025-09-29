<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Borra los registros respetando las claves foráneas
        DB::table('permission_user')->delete();
        Permission::query()->delete();

        $permissions = [
            ['name' => 'acceso-admin-dashboard'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
