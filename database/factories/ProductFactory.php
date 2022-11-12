<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->name,
            'price'         => $this->faker->randomFloat(2),
            'description'   => $this->faker->text,
            'category'      => $this->faker->word,
            'image_url'     => $this->faker->imageUrl
        ];
    }
}
