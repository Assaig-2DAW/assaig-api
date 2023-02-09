<?php

namespace Database\Seeders;

use App\Models\Suscriptor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuscriptorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Suscriptor::factory(10)->create();
    }
}
