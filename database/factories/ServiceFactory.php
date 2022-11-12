<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Unit;
use App\Models\ServiceCategory;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fakerFileName = $this->faker->image(
            storage_path("app/public"),
            800,
            600
        );

        $name = $this->faker->sentence(6);
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'institution_id' => $this->faker->numberBetween(1,10),
            'unit_id' => Unit::factory()->create()->id,
            'category_id' => ServiceCategory::factory()->create()->id,
            'description' => $this->faker->text(700),
            'responsiblePerson' => $this->faker->numberBetween(1,20),
    

        ];
    }
}
