<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => 'https://picsum.photos/1900/450?random='.rand(10,100),
            'filename' => $this->faker->text(10),
            'description' => $this->faker->text(50),
            'slug' => $this->faker->slug(),
            'institution_id' => 1,
            'category_id' => 1,
        ];
    }
}
