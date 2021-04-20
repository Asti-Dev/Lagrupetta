<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // create permissions
         Permission::create(['name' => 'cliente.index']);
         Permission::create(['name' => 'cliente.create']);
         Permission::create(['name' => 'cliente.edit']);
         Permission::create(['name' => 'cliente.delete']);
         Permission::create(['name' => 'bicicleta.index']);
         Permission::create(['name' => 'bicicleta.create']);
         Permission::create(['name' => 'bicicleta.edit']);
         Permission::create(['name' => 'bicicleta.delete']);
         Permission::create(['name' => 'empleado.index']);
         Permission::create(['name' => 'empleado.create']);
         Permission::create(['name' => 'empleado.edit']);
         Permission::create(['name' => 'empleado.delete']);
         Permission::create(['name' => 'pedidos.index']);
         Permission::create(['name' => 'pedidos.create']);
         Permission::create(['name' => 'pedidos.edit']);
         Permission::create(['name' => 'pedidos.delete']);

 
         // create roles and assign created permissions

         Role::create(['name' => 'cliente']);
         Role::create(['name' => 'administrador']);
         Role::create(['name' => 'chofer']);
         Role::create(['name' => 'mecanico']);
         Role::create(['name' => 'jefe mecanicos']);
         Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());
    }
}
