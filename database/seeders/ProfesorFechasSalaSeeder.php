<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fecha;
use App\Models\Profesor;
use App\Models\Profesor_fecha_sala;

class ProfesorFechasSalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fechas = Fecha::all();
        $fechas->each(function($fecha) {
            for($i = 0; $i < 2; $i++) {
                $profesor = Profesor::inRandomOrder()->first();
                Profesor_fecha_sala::factory()->create([
                    'fecha_id' => $fecha->id,
                    'profesor_id' => $profesor->id,
                ]);
            }

        });
    }
}
