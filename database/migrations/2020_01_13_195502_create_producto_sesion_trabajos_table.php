<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoSesionTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_sesion_trabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('sesion_trabajo_id')->unsigned();
            $table->BigInteger('producto_id')->unsigned();

            $table->foreign('sesion_trabajo_id')->references('id')->on('sesion_trabajos');
            $table->foreign('producto_id')->references('id')->on('productos');
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
        Schema::dropIfExists('producto_sesions');
    }
}
