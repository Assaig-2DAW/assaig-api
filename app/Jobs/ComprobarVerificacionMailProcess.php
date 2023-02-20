<?php

namespace App\Jobs;

use App\Http\Controllers\Api\ReservaController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComprobarVerificacionMailProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $reserva_id;
    //public $delay = 3600;
    public function __construct($reserva_id)
    {
        $this->reserva_id = $reserva_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ((new ReservaController)->comprobarVerificado($this->reserva_id));

    }
}
