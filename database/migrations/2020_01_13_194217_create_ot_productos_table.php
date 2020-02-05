<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero_pieza')->nullable();
            $table->integer('cantidad');
            $table->text('descripcion')->nullable();
            $table->BigInteger('ot_id')->unsigned();
            $table->BigInteger('producto_id')->unsigned();

            $table->foreign('ot_id')->references('id')->on('ots');
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
        Schema::dropIfExists('ot_productos');
    }
}
