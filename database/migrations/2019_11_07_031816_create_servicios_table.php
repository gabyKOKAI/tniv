<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->date('fechaPago')->nullable(true);
            $table->date('fechaInicio')->nullable(true);
            $table->date('fechaFin')->nullable(true);
            $table->integer('numCitas')->default(21)->nullable(false);
            $table->integer('numCitasAgendadas')->default(0)->nullable(false);
            $table->integer('numCitasTomadas')->default(0)->nullable(false);
            $table->integer('numCitasPerdidas')->default(0)->nullable(false);
            $table->boolean('valoracion')->default(False)->nullable(false);
            $table->boolean('postParto')->default(False)->nullable(false);
            $table->boolean('alimentacion')->default(False)->nullable(false);
            $table->string('estatus')->default("Pendiente")->nullable(false); #Pendiente, Pagado, Iniciado, Terminado, Suspendido

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
        Schema::dropIfExists('servicios');
    }
}
