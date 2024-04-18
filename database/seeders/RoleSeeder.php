<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Usuario']);

        // home
        Permission::create(['name' => 'home'])->syncRoles([$role1, $role2]);        

        // Administración
        Permission::create(['name' => 'administracion'])->syncRoles([$role1]);        
        // usuarios sistema        
        Permission::create(['name' => 'administracion.users.index'])->syncRoles([$role1]);        
        Permission::create(['name' => 'administracion.users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'administracion.users.update'])->syncRoles([$role1]);

        // Mantención
        Permission::create(['name' => 'mantencion'])->syncRoles([$role1, $role2]);
        // personal
        Permission::create(['name' => 'mantencion.personas.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.personas.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'mantencion.personas.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.personas.destroy'])->syncRoles([$role1]);
        // Naves
        Permission::create(['name' => 'mantencion.ships.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.ships.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.ships.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.ships.destroy'])->syncRoles([$role1, $role2]);
        // Rangos
        Permission::create(['name' => 'mantencion.rangos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.rangos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.rangos.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.rangos.destroy'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.rangos.show'])->syncRoles([$role1, $role2]);
        
        // Documentación
        Permission::create(['name' => 'mantencion.documentos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.documentos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.documentos.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.documentos.destroy'])->syncRoles([$role1, $role2]);

        // Parámetros
        Permission::create(['name' => 'mantencion.parameterdocs.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.parameterdocs.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.parameterdocs.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'mantencion.parameterdocs.destroy'])->syncRoles([$role1, $role2]);

        // Reportes
        Permission::create(['name' => 'reportes'])->syncRoles([$role1]);                
        
        // Control de Trayectoria                
        Permission::create(['name' => 'reportes.control-trayectoria.index'])->syncRoles([$role1]);                

        // Programación de Embarcos
        Permission::create(['name' => 'programacion-embarcos.index'])->syncRoles([$role1, $role2]);        

        // Control de Trayectoria                
        Permission::create(['name' => 'control-trayectoria.index'])->syncRoles([$role1, $role2]);

        // Documentos
        Permission::create(['name' => 'documentos.index'])->syncRoles([$role1, $role2]);
    }
}
