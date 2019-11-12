<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->date('fecha')->nullable(false);
            $table->boolean('vendas')->default(False)->nullable(false);
            $table->string('peso')->nullable(true);
            $table->string('foto')->nullable(true);
            $table->string('espalda')->nullable(true);
            $table->string('busto')->nullable(true);
            $table->string('cintura')->nullable(true);
            $table->string('abdomen')->nullable(true);
            $table->string('muslo')->nullable(true);
            $table->string('brazo')->nullable(true);

            $table->unsignedBigInteger('servicio_id');
			$table->foreign('servicio_id')->references('id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medidas');
    }
}
