<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('usuario_id')->unsigned();
            $table->BigInteger('area_id')->unsigned();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('area_id')->references('id')->on('areas');
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
        Schema::dropIfExists('area_usuarios');
    }
}
