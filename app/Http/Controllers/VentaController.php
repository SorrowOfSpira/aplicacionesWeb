<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Detalleventa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        
        $ventas = Venta::with([
            'cliente',
            'detalles.producto'
        ])
        ->orderBy('fecha', 'desc')
        ->get();

        return view('ventas.index', compact('ventas'));

    }
}