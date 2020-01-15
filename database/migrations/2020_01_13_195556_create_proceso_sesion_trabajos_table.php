<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoSesionTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_sesion_trabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('proceso_id')->unsigned();
            $table->BigInteger('sesion_trabajo_id')->unsigned();

            $table->foreign('proceso_id')->references('id')->on('procesos');
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
        Schema::dropIfExists('proceso_sesions');
    }
}
