<?php

namespace Database\Seeders;

use App\Models\Alergeno;
use App\Models\Alergeno_Reserva;
use App\Models\Profesor;
use App\Models\Profesor_fecha_cocina;
use App\Models\Reserva;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlergenoReservasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reservas = Reserva::all();
        $reservas->each(function( $reserva) {
            for($i = 0; $i < 2; $i++) {
                $alergeno = Alergeno::inRandomOrder()->first();
                Alergeno_Reserva::factory()->create([
                    'reserva_id' =>  $reserva->id,
                    'alergeno_id' => $alergeno->id,
                ]);
            }
        });
    }
}
