<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleSesionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_sesions', function (Blueprint $table) {
            $table->bigIncrements('id');     
            $table->BigInteger('sesion_trabajo_id')->unsigned();
            $table->BigInteger('ot_id')->unsigned();
            $table->BigInteger('producto_id')->unsigned();
            $table->BigInteger('sub_producto_id')->unsigned();
            $table->string('numero_pieza')->unsigned()->default(0);
            $table->BigInteger('proceso_id')->unsigned();
            $table->integer('cantidad')->default(0);

            $table->foreign('sesion_trabajo_id')->references('id')->on('sesion_trabajos');
            $table->foreign('ot_id')->references('id')->on('ots');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('sub_producto_id')->references('id')->on('sub_productos');
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
        Schema::dropIfExists('detalle_sesions');
    }
}
