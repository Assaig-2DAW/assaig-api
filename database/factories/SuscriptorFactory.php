<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suscriptor>
 */
class SuscriptorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => fake()->name(),
            'email' => fake()->email(),
            'cancelado' => fake()->boolean(),
            'fecha_baja' => fake()->dateTime()
        ];
    }
}
