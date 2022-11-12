<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
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
            'title' => $title,
            'slug' => $slug,
            'content' => $this->faker->text(700),
            'image' => 'https://picsum.photos/1900/450?random='.rand(10,100),
            'institution_id' => $this->faker->numberBetween(1,10),
            'status' => $this->faker->randomElement([true, false])
        ];
    }
}
