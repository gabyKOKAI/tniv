<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfCorreosFieldsToClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->boolean('correoAgendar')->default(True)->nullable(false);
            $table->boolean('correoCancelar')->default(True)->nullable(false);
            $table->boolean('aceptoCondiciones')->default(False)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
             $table->dropColumn('correoAgendar');
             $table->dropColumn('correoCancelar');
             $table->dropColumn('aceptoCondiciones');
        });
    }
}
