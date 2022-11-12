<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfficialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $slug = Str::slug($firstName.'-'.$lastName);

        return [
            'name' => $firstName.'-'.$lastName,
            'slug' => $slug,
            'image' => 'https://picsum.photos/1900/450?random='.rand(10,100),
            'institution_id' => 1,
            'unit_id' => 1,
            'position' => $this->faker->company,
            'area' => $this->faker->company,
            'decree' => $this->faker->company,
            'category' => $this->faker->company,
            'email' => $this->faker->email,
            'telephone' => $this->faker->phoneNumber,
            'extension' => '222',
            'dateOfAdmission' => $this->faker->date,
            'dateOfDischarge' => $this->faker->date,
            'status' => $this->faker->randomElement([true, false])
        ];
    }

           
}
