<?php

namespace Database\Seeders;

use App\Models\Fecha;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FechasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=10;$i++){
            Fecha::factory(1)->create();
        }
    }
}
