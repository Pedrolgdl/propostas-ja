<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitSchedulingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'property_id' => Property::all()->random()->id,
            'date' => $this->faker->date(),
            'schedule' => $this->faker->time(),
            'status' => $this->faker->randomElement(['Em espera', 'Marcada', 'Feita', 'Rejeitada']),
        ];
    }
}
