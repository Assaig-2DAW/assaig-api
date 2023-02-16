<?php

namespace Database\Seeders;

use App\Models\Fecha;
use App\Models\Profesor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Random\Randomizer;

class FechasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=5;$i++){
            Fecha::factory(1)->create();
            /*
            $id = $fecha->fecha;
            $fecha = Fecha::findOrFail($id);
            for($i=0; $i < 3; $i++) {
                dd($fecha);
                $profesor = Profesor::inRandomOrder()->first();
                $fecha->profesor_fecha_cocinas()->attach($profesor->id);
                $profesor = Profesor::inRandomOrder()->first();
                $fecha->profesor_fecha_salas()->attach($profesor->id);
            }*/
        }
        $fechas = Fecha::all();
        foreach ($fechas as $fecha) {
            $profesors_sala = Profesor::where('tipo', 'sala')->inRandomOrder()->get();
            $profesors_cocina = Profesor::where('tipo', 'cocina')->inRandomOrder()->get();
            for($i=0; $i <2; $i++) {
                $profesor_sala = $profesors_sala[$i];
                $profesor_cocina = $profesors_cocina[$i];
                $fecha->profesor_fecha_cocinas()->attach($profesor_cocina->id);
                $fecha->profesor_fecha_salas()->attach($profesor_sala->id);
            }
        }
    }
}
