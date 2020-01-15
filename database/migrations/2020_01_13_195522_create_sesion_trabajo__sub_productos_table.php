<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesionTrabajoSubProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesion_trabajo_sub_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('sub_producto_id')->unsigned();
            $table->BigInteger('sesion_trabajo_id')->unsigned();

            $table->foreign('sub_producto_id')->references('id')->on('sub_productos');
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
        Schema::dropIfExists('sesion_sub_productos');
    }
}
