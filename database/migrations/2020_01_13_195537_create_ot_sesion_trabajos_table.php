<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtSesionTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_sesion_trabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->BigInteger('ot_id')->unsigned();
            $table->BigInteger('sesion_trabajo_id')->unsigned();

            $table->foreign('ot_id')->references('id')->on('ots');
            $table->foreign('sesion_trabajo_id')->references('id')->on('sesion_trabajos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ot_sesions');
    }
}
