<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('nombre')->default("")->nullable(false);
            $table->string('numCliente')->default("")->nullable(false);
            $table->string('correo')->unique()->nullable(false);
            $table->string('estatus')->default("Inactivo")->nullable(false); #Activo, Inactivo, Terminado, Sin Kit
            $table->string('seEntero')->default("Facebook")->nullable(false); #Instagram, Facebook, Página, Recomedación,Otro
            $table->date('fechaNacimiento')->nullable(true);
            $table->float('altura')->default(0)->nullable(true);
            $table->string('direccion')->nullable(true);
            $table->string('telefono1')->nullable(true);
            $table->string('telefono2')->nullable(true);
            $table->string('nota')->nullable(true);

            $table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
