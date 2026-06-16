<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Detalleventa;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['cliente', 'detalles.producto'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($ventas);
    }

    public function show($id)
    {
        return response()->json(
            Venta::with(['cliente', 'detalles.producto'])->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'                      => 'required|date',
            'idcliente'                  => 'required|exists:cliente,id',
            'productos'                  => 'required|array|min:1',
            'productos.*.idproducto'     => 'required|exists:productos,id',
            'productos.*.cantidad'       => 'required|integer|min:1',
            'productos.*.preciounitario' => 'required|integer|min:1',
        ]);

        $venta = DB::transaction(function () use ($request) {
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

            return $venta->load(['cliente', 'detalles.producto']);
        });

        return response()->json($venta, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha'                      => 'required|date',
            'idcliente'                  => 'required|exists:cliente,id',
            'productos'                  => 'required|array|min:1',
            'productos.*.idproducto'     => 'required|exists:productos,id',
            'productos.*.cantidad'       => 'required|integer|min:1',
            'productos.*.preciounitario' => 'required|integer|min:1',
        ]);

        $venta = DB::transaction(function () use ($request, $id) {
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

            return $venta->load(['cliente', 'detalles.producto']);
        });

        return response()->json($venta);
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->detalles()->delete();
        $venta->delete();

        return response()->json(['message' => 'Venta eliminada.']);
    }
}
