<?php

namespace Database\Seeders;

use App\Models\Modulo;
use App\Models\Permiso;
use App\Models\Role;
use App\Models\RoleModulo;
use App\Models\RolePermiso;
use Illuminate\Database\Seeder;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') != 'prod') {
            $role1 = new Role();
            $role1->nombre = "System Administrator";
            $role1->descripcion = "Administrador del Sistema";
            $role1->save();

            foreach (Permiso::all() as $permiso) {
                $rp = new RolePermiso();
                $rp->role_id = $role1->id; //Administrador
                $rp->permiso_id = $permiso->id;
                $rp->save();
            }

            foreach (Modulo::all() as $modulo) {
                $rm = new RoleModulo();
                $rm->role_id = $role1->id;
                $rm->modulo_id = $modulo->id;
                $rm->save();
            }

            $role2 = new Role();
            $role2->nombre = "Role Secundario";
            $role2->descripcion = "Role Secundario del Sistema";
            $role2->save();

            foreach (Permiso::all() as $permiso) {
                if ($permiso->id != 4) {
                    $rp = new RolePermiso();
                    $rp->role_id = $role2->id;
                    $rp->permiso_id = $permiso->id;
                    $rp->save();
                }
            }

            foreach (Modulo::all() as $modulo) {
                $rm = new RoleModulo();
                $rm->role_id = $role2->id;
                $rm->modulo_id = $modulo->id;
                $rm->save();
            }
        } else {
            $role = new Role();
            $role->nombre = "System Administrator";
            $role->descripcion = "Administrador del Sistema";
            $role->save();

            foreach (Permiso::all() as $permiso) {
                $rp = new RolePermiso();
                $rp->role_id = $role->id;
                $rp->permiso_id = $permiso->id;
                $rp->save();
            }

            foreach (Modulo::all() as $modulo) {
                $rm = new RoleModulo();
                $rm->role_id = $role->id;
                $rm->modulo_id = $modulo->id;
                $rm->save();
            }
        }
    }
}