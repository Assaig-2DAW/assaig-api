<?php

namespace Database\Seeders;

use App\Models\Alergeno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlergenosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alergeno1 = new Alergeno();
        $alergeno1->nombre = 'gluten';
        $alergeno1->icono = 1;
        $alergeno1->save();

        $alergeno2 = new Alergeno();
        $alergeno2->nombre = 'crustaceos';
        $alergeno2->icono = 2;
        $alergeno2->save();

        $alergeno3 = new Alergeno();
        $alergeno3->nombre = 'huevo';
        $alergeno3->icono = 3;
        $alergeno3->save();

        $alergeno4 = new Alergeno();
        $alergeno4->nombre = 'pescado';
        $alergeno4->icono = 4;
        $alergeno4->save();

        $alergeno5 = new Alergeno();
        $alergeno5->nombre = 'cacahuetes';
        $alergeno5->icono = 5;
        $alergeno5->save();

        $alergeno6 = new Alergeno();
        $alergeno6->nombre = 'soja';
        $alergeno6->icono = 6;
        $alergeno6->save();

        $alergeno7 = new Alergeno();
        $alergeno7->nombre = 'lacteos';
        $alergeno7->icono = 7;
        $alergeno7->save();

        $alergeno8 = new Alergeno();
        $alergeno8->nombre = 'frutos con cáscara';
        $alergeno8->icono = 8;
        $alergeno8->save();

        $alergeno9 = new Alergeno();
        $alergeno9->nombre = 'apio';
        $alergeno9->icono = 9;
        $alergeno9->save();

        $alergeno10 = new Alergeno();
        $alergeno10->nombre = 'mostaza';
        $alergeno10->icono = 10;
        $alergeno10->save();

        $alergeno11 = new Alergeno();
        $alergeno11->nombre = 'sésamo';
        $alergeno11->icono = 11;
        $alergeno11->save();

        $alergeno12 = new Alergeno();
        $alergeno12->nombre = 'sulfitos';
        $alergeno12->icono = 12;
        $alergeno12->save();

        $alergeno13 = new Alergeno();
        $alergeno13->nombre = 'moluscos';
        $alergeno13->icono = 13;
        $alergeno13->save();

        $alergeno14 = new Alergeno();
        $alergeno14->nombre = 'altramuces';
        $alergeno14->icono = 14;
        $alergeno14->save();

    }
}
