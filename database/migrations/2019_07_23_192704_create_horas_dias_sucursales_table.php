<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorasDiasSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('hora')->nullable(false);
            $table->integer('numCitasMax')->default(1)->nullable(false);
            $table->string('estatus')->default("Inactivo")->nullable(false); #Abierto, Cerrado, Inactivo

            $table->unsignedBigInteger('dia_id');
			$table->foreign('dia_id')->references('id')->on('dias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horas');
    }
}
