<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre'=> fake()->name(),
            'email'=> fake()->unique()->safeEmail(),
            'telefono'=> fake()->numerify(fake()->randomElement(['6########', '9########'])),
            'comensales'=> fake()->numberBetween(5,7),
            'observaciones' => fake()->sentence(2),
            'localizador' => fake()->unique()->lexify('?????'),
            'confirmada' => fake()->boolean(),
            'en_espera' => fake()->boolean(),
            'verify' => fake()->boolean(),
        ];
    }
}
