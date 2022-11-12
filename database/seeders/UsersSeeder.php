<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();

        DB::table('users')->insert([
            [
                'role_id' => '1',
                'email' => 'admin@pruebas.com',
                'email_verified_at' => $date,
                'password' => bcrypt('admin'),
                'created_at' => $date,
                'updated_at' => $date
            ],
            
        ]);

        DB::table('profiles')->insert([
            [
                'user_id' => '1',
                'name' => 'Administrador Pruebas',
                'phone' => '888-888-8888',
                'movil' => '888-888-8888',
                'created_at' => $date,
                'updated_at' => $date
            ],
        ]);

        if (env('APP_ENV') != 'prod') {
            DB::table('users')->insert([
                [
                    'role_id' => '2',
                   
                    'email' => 'user@pruebas.com',
                    'email_verified_at' => $date,
                    'password' => bcrypt('admin'),
                    'created_at' => $date,
                    'updated_at' => $date
                ],
            ]);
    
            DB::table('profiles')->insert([
                [
                    'user_id' => '2',
                    'name' => 'Usuario Pruebas',
                    'phone' => '809-999-9999',
                    'movil' => '809-999-9999',
                    'created_at' => $date,
                    'updated_at' => $date
                ],
            ]);
        }

        
    }
}