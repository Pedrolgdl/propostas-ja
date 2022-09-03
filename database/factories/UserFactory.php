<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Utilizando faker para popular o banco
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'telephone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date(),
            'cpf' => $this->faker->cpf(),
            'role' => $this->faker->boolean(),
            'email' => preg_replace('/@example\..*/', '@byronsolutions.com', $this->faker->unique()->safeEmail),
            'password' => Hash::make('password'), 
            'userPhoto' => '',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
