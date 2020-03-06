<?php

namespace App\Http\Controllers;

use App\Producto;
use App\SubProducto;
use App\OtProducto;
use App\ClienteProducto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function obtenerProductosOt($id)//id de la ot
    {
        $productos= OtProducto::where('ot_id', $id)->get();
        if(count($productos) == 0){
            return 0;
        }
        //filtro repetidos
        $productosFiltrados = array();
        foreach($productos as $producto){
            if(!in_array($producto->producto_id, $productosFiltrados)){
                $productosFiltrados[] = $producto->producto_id;
            }
        }
        $productosCompletos = array();
        foreach($productosFiltrados as $id){
            $prod = Producto::find($id);
            $productosCompletos[] = $prod;
        }
        return $productosCompletos;
    }

    public function obtenerCantidadPorOt(Request $request)
    {
        $todo = $request->input('todo');
        $cantidades = array();
        foreach($todo as $e){
            $idProd = $e[1]['id'];
            $aux = OtProducto::where('producto_id', $e[1]['id'])->where('ot_id',$e[0]['id'])->get();;
            $cantidades[] = $aux[0]['cantidad'];
        }
        return $cantidades;
    }

    public function index()
    {
        $productos = Producto::orderBy('nombre_producto')->get();
        return $productos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nombreSend = $request->input('nombre');
        $codigoSiomSend = $request->input('codigoSiom');
        $numeroPlanoSend = $request->input('numeroPlano');
        $descripcionSend = $request->input('descripcion');
        $tipoIdSend = $request->input('tipoMaterial');
        $clienteIdSend = $request->input('cliente');
        $codigoClienteSend = $request->input('codigoCliente');
        #creamos el nuevo producto
        $producto = new Producto;
        #asigamos los atributos al producto
        $producto->nombre_producto = $nombreSend;
        $producto->codigo_siom = $codigoSiomSend;
        $producto->numero_plano = $numeroPlanoSend;
        $producto->descripcion = $descripcionSend;
        $producto->tipo_material_id = $tipoIdSend;
        #guardamos el producto
        $producto->save();

        #Ahora con la tabla intermedia
        $linea = new ClienteProducto;
        $linea->cliente_id = $clienteIdSend;
        $linea->producto_id = $producto->id;
        $linea->codigo_cliente = $codigoClienteSend;
        $linea->save();
        return 'CORRECTO';
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $nombreSend = $request->input('nombre');
        $codigoSiomSend = $request->input('codigoSiom');
        $numeroPlanoSend = $request->input('numeroPlano');
        $descripcionSend = $request->input('descripcion');
        $tipoIdSend = $request->input('tipoMaterial');
        #obtenemos el producto
        $producto = Producto::find($producto->id);
        #$producto = $producto[0];
        #editamos el producto
        $producto->nombre_producto = $nombreSend;
        $producto->codigo_siom = $codigoSiomSend;
        $producto->numero_plano = $numeroPlanoSend;
        $producto->descripcion = $descripcionSend;
        $producto->tipo_material_id = $tipoIdSend;
        #guardamos el producto
        $producto->save();
        return 'CORRECTO';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $prod = Producto::find($producto->id);
        $prod->delete();
        return "CORRECTO";
    }

    public function cerrarProducto($id){
        $ot = Producto::find($id);
        $ot->activo= false;
        $ot->save();
        return "CORRECTO";
    }
    public function abrirProducto($id){
        $ot = Producto::find($id);
        $ot->activo= true;
        $ot->save();
        return "CORRECTO";
    }
}
