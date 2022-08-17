<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$usersId = \App\Models\User::pluck('id')->toArray();

        return [
            //'user_id' => $this->faker->randomNumber($usersId), 
            'user_id' =>  User::all()->random()->id,
            'confirmed' => $this->faker->boolean(), 
            'type' => $this->faker->randomElement(['Casa', 'Apartamento', 'Kitnet']), 
            'title' => $this->faker->realText(30), 
            'description' => $this->faker->optional()->realText(200), 
            'price' => $this->faker->randomFloat(2, 0, 200000),
            'iptu' => $this->faker->randomFloat(2, 0, 20000),
            'size' => $this->faker->randomNumber(3, true), 
            'number_rooms' => $this->faker->numberBetween(0, 15), 
            'number_bathrooms' => $this->faker->numberBetween(0, 15), 
            'furnished' => $this->faker->boolean(), 
            'disability_access' => $this->faker->boolean(),
            'accepts_pet' => $this->faker->optional()->boolean(),
            'garage' => $this->faker->optional()->randomDigit(),  
            'apartment_floor' => $this->faker->optional()->numberBetween(0, 127),
            'condominium' => $this->faker->optional()->randomFloat(2, 0, 10000), 
            'condominium_description' => $this->faker->optional()->realText(200),
            'fire_insurance' => $this->faker->optional()->randomFloat(2, 0, 5000), 
            'service_charge' => $this->faker->optional()->randomFloat(2, 0, 5000),
            // 'state' => $this->faker->state(),
            // 'cep' => $this->faker->postcode(), 
            // 'city' => $this->faker->city(), 
            // 'neighborhood' => $this->faker->streetAddress(), 
            // 'street' => $this->faker->streetName(), 
            // 'house_number' => $this->faker->numberBetween(0, 3000),
            // 'nearby' => $this->faker->optional()->realText(50),
        ];
    }
}
