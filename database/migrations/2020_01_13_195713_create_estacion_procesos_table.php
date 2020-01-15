<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estacion_procesos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('estacion_id')->unsigned();
            $table->BigInteger('proceso_id')->unsigned();

            $table->foreign('estacion_id')->references('id')->on('estacions');
            $table->foreign('proceso_id')->references('id')->on('procesos');
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
        Schema::dropIfExists('estacion_procesos');
    }
}
