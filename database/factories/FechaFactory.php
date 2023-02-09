<?php

namespace Database\Factories;

use App\Models\Fecha;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fecha>
 */
class FechaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function getNextFriday() {

        $semana = count(Fecha::all());
        $fecha_actual = new Carbon();
        $fecha_actual->nextWeekendDay()->subDay();
        $fecha_actual->addWeeks($semana);

        return $fecha_actual->format("Y-m-d");

    }
    public function definition()
    {
        $openTime = new DateTime();
        $openTime->setTime(14, 0);
        $closeTime = new DateTime();
        $closeTime->setTime(16, 0);

        return [
            'fecha' => $this->getNextFriday(),
            'pax' => 15,
            'overbooking' => 5,
            'pax_espera' => 0,
            'horario_apertura' => $openTime,
            'horario_cierre' => $closeTime,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
