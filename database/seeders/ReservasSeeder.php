<?php

namespace Database\Seeders;

use App\Models\Alergeno;
use App\Models\Fecha;
use App\Models\Profesor;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $fechas = Fecha::all();
        $fechas->each(function($fecha) {
            Reserva::factory()->count(2)->create([
                'fecha_id' => $fecha->id,
            ]);
        });
        $reservas = Reserva::all();
        foreach ($reservas as $reserva) {
            $random = random_int(0, 14);
            for($i=1; $i<=$random; $i++){
                $reserva->alergeno_reservas()->attach($i);
            }
        }
        */
    }
}
