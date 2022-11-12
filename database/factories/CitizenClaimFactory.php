<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CitizenClaimFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $identificationNumber = $this->faker->randomElement([
            $this->faker->numerify('402-#######-#'),
            $this->faker->numerify('068-#######-#'),
        ]);
        
        return [
            'names' => $this->faker->name(), 
            'lastnames' => $this->faker->lastName(), 
            'identification_document' => $identificationNumber, 
            'gender' => $this->faker->randomElement(['male', 'female']), 
            'sector' => $this->faker->citySuffix(), 
            'street' => $this->faker->streetName(), 
            'house_number' => $this->faker->numberBetween(1,1000),
            'reference_phone_number' => $this->faker->phoneNumber(),
            'phone_number' => $this->faker->phoneNumber(), 
            'email' => $this->faker->email(),
            'province_id' => $this->faker->numberBetween(1, 9),
            'municiple_id' => $this->faker->numberBetween(1, 9)
        ];
    }
}
