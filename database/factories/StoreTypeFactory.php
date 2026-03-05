<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()    
    {
        return [ 
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'image' => $this->faker->imageUrl(640, 480, 'business', true),
            'icon' => $this->faker->imageUrl(100, 100, 'business', true),
            'status' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ]; 
    }
}
