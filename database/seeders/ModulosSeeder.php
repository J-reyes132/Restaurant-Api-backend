<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();

        DB::table('modulos')->insert([
            [
                'nombre' => 'Pedidos',
                'descripcion' => 'Modulo Pedidos',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'nombre' => 'usuarios',
                'descripcion' => 'Modulo Usuarios',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'nombre' => 'roles',
                'descripcion' => 'Modulo Roles',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'nombre' => 'Facturas',
                'descripcion' => 'Modulo facturas del Sistema',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'nombre' => 'menus',
                'descripcion' => 'Modulo menus',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'nombre' => 'clientes',
                'descripcion' => 'Modulo clientes',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'nombre' => 'productos',
                'descripcion' => 'Modulo productos',
                'created_at' => $date,
                'updated_at' => $date
            ],
        ]);
    }
}