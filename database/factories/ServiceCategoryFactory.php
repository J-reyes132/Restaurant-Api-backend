<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company;
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'code' => $this->faker->numberBetween(1000, 9000),
            // 'status' => $this->faker->randomElement([true, false])
        ];
    }
}
