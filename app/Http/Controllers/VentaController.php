<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Cliente;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['producto', 'categoria', 'cliente'])->get();
        $productos = Producto::all();
        $categorias = Categoria::all();
        $clientes = Cliente::all();
        return view('ventas.index', compact('ventas', 'productos', 'categorias', 'clientes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'cliente_id' => 'required',
            'fecha_venta' => 'required|date',
            'subtotal' => 'required|numeric',
            'iva' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        Venta::create($request->all());

        return redirect()->route('ventas.index')
            ->with('success', 'Venta creada exitosamente.');
    }

    public function edit($id)
    {
        $venta = Venta::find($id);
        $productos = Producto::all();
        $categorias = Categoria::all();
        $clientes = Cliente::all();

        return response()->json(compact('venta', 'productos', 'categorias', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'cliente_id' => 'required',
            'fecha_venta' => 'required|date',
            'subtotal' => 'required|numeric',
            'iva' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $venta = Venta::find($id);
        $venta->update($request->all());

        return redirect()->route('ventas.index')
            ->with('success', 'Venta actualizada exitosamente.');
    }

    public function destroy($id)
    {
        Venta::find($id)->delete();

        return redirect()->route('ventas.index')
            ->with('success', 'Venta eliminada exitosamente.');
    }
}
