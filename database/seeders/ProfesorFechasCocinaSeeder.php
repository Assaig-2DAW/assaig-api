<?php

namespace Database\Seeders;

use App\Models\Fecha;
use App\Models\Profesor;
use App\Models\Profesor_fecha_cocina;
use App\Models\Profesor_fecha_sala;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesorFechasCocinaSeeder extends Seeder
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
                Profesor_fecha_cocina::factory()->create([
                    'fecha_id' => $fecha->id,
                    'profesor_id' => $profesor->id,
                ]);
            }

        });
    }
}
