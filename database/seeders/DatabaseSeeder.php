<?php

namespace Database\Seeders;

use App\Models\Citizen;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        #Usuarios | Módulos | Permisos Base
        $this->Call(PermisosSeeder::class);
        $this->Call(ModulosSeeder::class);
        $this->Call(RolesSeeder::class);

        #Necesario antes de los Usuarios, por que el Usuario necesita una institución a la cual pertenecer
        
        $this->Call(UsersSeeder::class);

        $this->call(CustomerSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(TableSeeder::class);
        
        if (env('APP_ENV') == 'local') {

            // User::factory(60)->create();
            // \App\Models\User::factory(10)->create();

        }


        // ModelClass::factory(20)->create();

    }
}
