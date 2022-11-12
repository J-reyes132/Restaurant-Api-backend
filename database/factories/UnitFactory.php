<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
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
            'institution_id' => $this->faker->numberBetween(1,5),
            'description' => $this->faker->text(700),
            'status' => $this->faker->randomElement([1, 0])
        ];
    }
}
