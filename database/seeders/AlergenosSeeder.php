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
        Alergeno::factory(14)->create();
    }
}
