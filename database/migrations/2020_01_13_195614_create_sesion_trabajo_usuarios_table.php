<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesionTrabajoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesion_trabajo_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('usuario_id')->unsigned();
            $table->BigInteger('sesion_trabajo_id')->unsigned();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('sesion_trabajo_id')->references('id')->on('sesion_trabajos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sesion_usuarios');
    }
}
