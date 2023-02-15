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
        Fecha::factory(5)->create();
        /*
        for ($i=1;$i<=10;$i++){
            Fecha::factory(1)->create();

            $id = $fecha->fecha;
            $fecha = Fecha::findOrFail($id);
            for($i=0; $i < 3; $i++) {
                dd($fecha);
                $profesor = Profesor::inRandomOrder()->first();
                $fecha->profesor_fecha_cocinas()->attach($profesor->id);
                $profesor = Profesor::inRandomOrder()->first();
                $fecha->profesor_fecha_salas()->attach($profesor->id);
            }
        }
        */
        $fechas = Fecha::all();
        foreach ($fechas as $fecha) {
            $profesors = Profesor::inRandomOrder()->get();
            for($i=0; $i <4; $i++) {
                $profesor = $profesors[$i];
                if($i%2 == 0) {
                    $fecha->profesor_fecha_cocinas()->attach($profesor->id);
                } else {
                    $fecha->profesor_fecha_salas()->attach($profesor->id);
                }
            }
        }
    }
}
