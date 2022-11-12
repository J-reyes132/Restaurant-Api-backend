<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();

        $permiso1 = new Permiso();
        $permiso1->nombre = 'read';
        $permiso1->descripcion = 'Leer Datos';
        $permiso1->save();

        $permiso2 = new Permiso();
        $permiso2->nombre = 'create';
        $permiso2->descripcion = 'Crear Datos';
        $permiso2->save();

        $permiso3 = new Permiso();
        $permiso3->nombre = 'update';
        $permiso3->descripcion = 'Editar Datos';
        $permiso3->save();

        $permiso4 = new Permiso();
        $permiso4->nombre = 'destroy';
        $permiso4->descripcion = 'Borrar Datos';
        $permiso4->save();

        $permiso5 = new Permiso();
        $permiso5->nombre = 'deactivate';
        $permiso5->descripcion = 'Desactivar Datos';
        $permiso5->save();

    }
}