<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('email', 125);
            $table->string('telefono', 9);
            $table->integer('comensales')->default(1);
            $table->text('observaciones')->nullable();
            $table->string('localizador')->unique();
            $table->boolean('confirmada')->default(0);
            $table->boolean('en_espera')->default(0);
            $table->boolean('verify')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
};
