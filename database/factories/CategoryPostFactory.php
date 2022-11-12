<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class CategoryPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(6);
        $slug = Str::slug($title);

        return [
            "post_id" =>  $this->faker->numberBetween(1,10),
            "category_id" => $this->faker->numberBetween(1,10), 
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];
    }
}
