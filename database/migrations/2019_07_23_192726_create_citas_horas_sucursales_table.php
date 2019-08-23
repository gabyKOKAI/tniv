<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasHorasSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('estatus')->default("Inactivo")->nullable(false); #Abierto, Cerrado, Inactivo
            $table->string('nota')->default("");

            $table->unsignedBigInteger('hora_id');
			$table->foreign('hora_id')->references('id')->on('horas');

			$table->unsignedBigInteger('cliente_id');
			$table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
