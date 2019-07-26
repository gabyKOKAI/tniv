<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiasMesesSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('numDia')->nullable(false);
            $table->string('diaSemana')->nullable(false);
            $table->boolean('estatus')->default(False)->nullable(false);

            $table->unsignedBigInteger('mes_id');
			$table->foreign('mes_id')->references('id')->on('meses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dias');
    }
}
