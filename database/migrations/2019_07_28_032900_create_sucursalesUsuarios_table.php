<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalesUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursalesUsuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->boolean('estatus')->default(False)->nullable(false); #Activo, Inactivo

            $table->unsignedBigInteger('usuario_id');
			$table->foreign('usuario_id')->references('id')->on('users');

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
        Schema::dropIfExists('sucursalesUsuario');
    }
}
