<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\People>
 */
class PeopleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'per_nombres'    => $this->faker->firstName,
            'per_apellidopat' => $this->faker->lastName,
            'per_apellidomat' => $this->faker->lastName,
            'per_ci'         => $this->faker->numerify('########'),
            'per_direccion'  => $this->faker->address,
            'per_telefono'   => $this->faker->phoneNumber,
            'per_celular'    => $this->faker->numerify('7########'),
            'per_estado'     => $this->faker->randomElement([0, 1]),
        ];
    }
}
