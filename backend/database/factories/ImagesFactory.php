<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Images>
 */
class ImagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path' => $this->faker->imageUrl(),
            'extension' => $this->faker->fileExtension,
            'name' => $this->faker->sentence(rand(1, 2)),
            'product_id' => $this->faker->numberBetween(1, 150),
        ];
    }
}
