<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Detalleventa;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['cliente', 'detalles.producto'])
            ->orderBy('id', 'desc')
            ->get();

        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes  = Cliente::orderBy('apellido')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'                       => 'required|date',
            'idcliente'                   => 'required|exists:cliente,id',
            'productos'                   => 'required|array|min:1',
            'productos.*.idproducto'      => 'required|exists:productos,id',
            'productos.*.cantidad'        => 'required|integer|min:1',
            'productos.*.preciounitario'  => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $venta = Venta::create([
                'fecha'     => $request->fecha,
                'idcliente' => $request->idcliente,
            ]);

            foreach ($request->productos as $item) {
                Detalleventa::create([
                    'idventa'        => $venta->id,
                    'idproducto'     => $item['idproducto'],
                    'cantidad'       => $item['cantidad'],
                    'preciounitario' => $item['preciounitario'],
                ]);
            }
        });

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function edit($id)
    {
        $venta     = Venta::with('detalles')->findOrFail($id);
        $clientes  = Cliente::orderBy('apellido')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha'                       => 'required|date',
            'idcliente'                   => 'required|exists:cliente,id',
            'productos'                   => 'required|array|min:1',
            'productos.*.idproducto'      => 'required|exists:productos,id',
            'productos.*.cantidad'        => 'required|integer|min:1',
            'productos.*.preciounitario'  => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $id) {
            $venta = Venta::findOrFail($id);
            $venta->update([
                'fecha'     => $request->fecha,
                'idcliente' => $request->idcliente,
            ]);

            $venta->detalles()->delete();

            foreach ($request->productos as $item) {
                Detalleventa::create([
                    'idventa'        => $venta->id,
                    'idproducto'     => $item['idproducto'],
                    'cantidad'       => $item['cantidad'],
                    'preciounitario' => $item['preciounitario'],
                ]);
            }
        });

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->detalles()->delete();
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }
}
