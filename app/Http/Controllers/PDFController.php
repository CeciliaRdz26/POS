<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use App\Models\CotizacionProducto;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function report($id){
        
        $pdf = app('dompdf.wrapper');

        $cotizacion = Cotizacion::find($id);
        $cotizacionProducto = CotizacionProducto::where('id_cotizacion', $cotizacion->id_cotizaciones)->get();

        $texto = "<h1>Nombre cliente: </h1> <h2>". $cotizacion->cliente->nombre ."</h2>".
                 "<h2>Fecha de cotizacion: </h2> <h3>". $cotizacion->fecha_cot ."</h3>".
                 "<h2>Fecha de vigencia: </h2> <h3>". $cotizacion->vigencia ."</h3>";

        $cuerpo = $texto. "<br>" . "";

        foreach ($cotizacionProducto as $cotizacionProduc) {
            $cuerpo = $cuerpo . "<h3>Nombre del producto: </h3><p>". $cotizacionProduc->producto->nombre ."</p>".
                                "<h3>Cantidad: </h3><p>". $cotizacionProduc->cantidad ."</p>".
                                "<h3>Precio: </h3><p>". $cotizacionProduc->precio_venta ."</p>". 
                                "<h3>Total del producto: </h3><p>". $cotizacionProduc->cantidad * $cotizacionProduc->precio_venta."</p>".
                                "<br>";
        }

        $pdf->loadHTML($cuerpo);

        return $pdf->download($cotizacion->cliente->nombre.'.pdf');

    }
}
