<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('nombre')->default("")->nullable(false);
            $table->time('horaInicio')->default('08:00:00')->nullable(false);
            $table->time('horaFin')->default('17:30:00')->nullable(false);
            $table->time('horaComida')->default('14:00:00')->nullable(false);
            $table->string('direccion')->nullable(true);
            $table->string('telefono1')->nullable(true);
            $table->string('telefono2')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sucursales');
    }
}
