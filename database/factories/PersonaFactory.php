<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\People>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombres'    => $this->faker->firstName,
            'apellidopat' => $this->faker->lastName,
            'apellidomat' => $this->faker->lastName,
            'carnet'         => $this->faker->numerify('########'),
            'direccion'  => $this->faker->address,
            'telefono'   => $this->faker->phoneNumber,
            'estado'     => $this->faker->randomElement([0, 1]),
        ];
    }
}
