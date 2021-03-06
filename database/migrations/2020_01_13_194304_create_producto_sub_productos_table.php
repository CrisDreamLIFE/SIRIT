<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoSubProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_sub_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('sub_producto_id')->unsigned();
            $table->BigInteger('producto_id')->unsigned();

            $table->foreign('sub_producto_id')->references('id')->on('sub_productos');
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
        Schema::dropIfExists('producto_sub_productos');
    }
}
