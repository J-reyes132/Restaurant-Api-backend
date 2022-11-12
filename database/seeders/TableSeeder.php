<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        DB::table('tables')->insert([
            [
                'capacity' => 6,
                'created_at' => $date,
                'updated_at' => $date

            ],
            [
                'capacity' => 4,
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'capacity' => 8,
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'capacity' => 12,
                'created_at' => $date,
                'updated_at' => $date
            ],

        ]);
    }
}
