<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // descomentar para ejecutar seed de roles y permisos       
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('users')->delete();        

        $admin = Role::create(['name' => 'Administrador']);
        $user = Role::create(['name' => 'Usuario']);        
        $invitado = Role::create(['name' => 'Invitado']);

        /* User::create([
            'name' => 'Administrador',
            'email' => 'admin@cmcflota.cl',
            'password' => bcrypt('pass1234')
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Usuario',
            'email' => 'usuario@cmcflota.cl',
            'password' => bcrypt('pass1234')
        ])->assignRole('Usuario');

        User::create([
            'name' => 'Invitado',
            'email' => 'invitado@cmcflota.cl',
            'password' => bcrypt('pass1234')
        ]); */

        // home
        Permission::create(['name' => 'home'])->syncRoles([$admin, $user]);        

        // Documentación
        Permission::create(['name' => 'documentos.index'])->syncRoles([$admin, $user]);

        // Control de Trayectoria                
        Permission::create(['name' => 'control-trayectoria.index'])->syncRoles([$admin, $user]);

        /* // Control de Trayectoria                
        Permission::create(['name' => 'reportes.control-trayectoria.index'])->syncRoles([$admin]);       */          

        // Programación de Embarcos
        Permission::create(['name' => 'programacion-embarcos.index'])->syncRoles([$admin, $user]);        

        // Reportes
        Permission::create(['name' => 'reportes'])->syncRoles([$admin]);                                      
        
        // Mantención
        Permission::create(['name' => 'mantencion'])->syncRoles([$admin, $user]);
        // personal
        Permission::create(['name' => 'mantencion.personas.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.personas.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'mantencion.personas.edit'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.personas.destroy'])->syncRoles([$admin]);
        // Naves
        Permission::create(['name' => 'mantencion.ships.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.ships.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.ships.edit'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.ships.destroy'])->syncRoles([$admin]);
        // Rangos
        Permission::create(['name' => 'mantencion.rangos.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.rangos.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.rangos.edit'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.rangos.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.rangos.show'])->syncRoles([$admin]);
        
        // Documentación
        Permission::create(['name' => 'mantencion.documentos.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.documentos.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.documentos.edit'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.documentos.destroy'])->syncRoles([$admin]);

        // Parámetros
        Permission::create(['name' => 'mantencion.parameterdocs.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.parameterdocs.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.parameterdocs.edit'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.parameterdocs.destroy'])->syncRoles([$admin]);

        // Tipos de Nave
        Permission::create(['name' => 'mantencion.ship_tipos.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.ship_tipos.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.ship_tipos.edit'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.ship_tipos.destroy'])->syncRoles([$admin]);

        // Feriados
        Permission::create(['name' => 'mantencion.feriados.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.feriados.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.feriados.edit'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'mantencion.feriados.destroy'])->syncRoles([$admin]);

        // Administración
        Permission::create(['name' => 'administracion'])->syncRoles([$admin]);        
        // usuarios sistema        
        Permission::create(['name' => 'administracion.users.index'])->syncRoles([$admin]);        
        Permission::create(['name' => 'administracion.users.edit'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'administracion.users.update'])->syncRoles([$admin]);
        
    }
}
