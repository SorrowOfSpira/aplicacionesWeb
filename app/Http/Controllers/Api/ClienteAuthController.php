<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $cliente = Cliente::where('email', $request->email)->first();

        if (! $cliente || ! Hash::check($request->password, $cliente->password)) {
            return response()->json(['message' => 'Credenciales incorrectas.'], 401);
        }

        $token = $cliente->createToken('cliente-token')->plainTextToken;

        return response()->json([
            'token'   => $token,
            'cliente' => [
                'id'       => $cliente->id,
                'nombre'   => $cliente->nombre,
                'apellido' => $cliente->apellido,
                'email'    => $cliente->email,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('clientes')->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada.']);
    }

    public function me(Request $request)
    {
        $cliente = $request->user('clientes');

        return response()->json([
            'id'        => $cliente->id,
            'nombre'    => $cliente->nombre,
            'apellido'  => $cliente->apellido,
            'email'     => $cliente->email,
            'telefono'  => $cliente->telefono,
            'direccion' => $cliente->direccion,
        ]);
    }

    public function misVentas(Request $request)
    {
        $ventas = $request->user('clientes')
            ->ventas()
            ->with('detalles.producto')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($ventas);
    }
}
