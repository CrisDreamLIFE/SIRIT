 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('ots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ot_Perú')->nullable(); 
            $table->date('fecha_recepción');  //no null
            $table->string('orden_compra')->nullable();
            $table->string('numero_cotización')->nullable();
            $table->text('observacion')->nullable();
            $table->date('fecha_entrega_oc');
            $table->date('fecha_real_entrega')->nullable();
            $table->date('fecha_despacho')->nullable();
            $table->string('guia_despacho')->nullable();
            $table->string('factura')->nullable();
            $table->boolean('abierta')->default(TRUE); 
            $table->boolean('recepcionada')->default(FALSE);
            $table->boolean('despachada')->default(FALSE);

            #foraneas
            
            $table->BigInteger('canal_venta_id')->unsigned();
            $table->BigInteger('ot_tipo_id')->unsigned();
            $table->BigInteger('responsable_id')->unsigned();
            $table->BigInteger('centro_costo_id')->unsigned();
            $table->BigInteger('categoria_ot_id')->unsigned();
            $table->BigInteger('cliente_id')->unsigned();

             $table->foreign('cliente_id')->references('id')->on('clientes');           
            $table->foreign('canal_venta_id')->references('id')->on('canal_ventas');
            $table->foreign('ot_tipo_id')->references('id')->on('ot_tipos');
            $table->foreign('responsable_id')->references('id')->on('usuarios');
            $table->foreign('centro_costo_id')->references('id')->on('centro_costos');
            $table->foreign('categoria_ot_id')->references('id')->on('categoria_ots');

            //$table->time('mi_hora');
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
        Schema::dropIfExists('ots');
    }
}
