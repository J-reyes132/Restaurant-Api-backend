<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        DB::table('products')->insert([
            [
                'name' => 'Res a la plancha',
                'description' => 'filete de res a la plancha',
                'price' => 450,
                'category' => 'plato',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'name' => 'Mojito',
                'description' => '',
                'price' => 400,
                'category' => 'bebida',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'name' => 'Agua',
                'description' => 'Agua',
                'category' => 'bebida',
                'price' => 80,
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'name' => 'Jugo Natural',
                'description' => 'filete de res a la plancha',
                'category' => 'bebida',
                'price' => 150,
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'name' => 'Pechuga a la plancha',
                'description' => 'filete de pechuga a la plancha',
                'category' => 'plato',
                'price' => 450,
                'created_at' => $date,
                'updated_at' => $date
            ],
            
        ]);
    }
}
