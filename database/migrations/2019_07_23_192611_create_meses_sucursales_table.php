<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesesSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('mes')->nullable(false);
            $table->integer('ano')->nullable(false);
            $table->string('estatus')->default("Inactivo")->nullable(false); #Abierto, Cerrado, Inactivo

            $table->unsignedBigInteger('sucursal_id');
			$table->foreign('sucursal_id')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meses');
    }
}
