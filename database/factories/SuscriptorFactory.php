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
            'nombre' => 'admin',
            'email' => 'admin@admin.com',
            'cancelado' => false,
            'fecha_baja' => '2055-12-31'
        ];
    }
}
