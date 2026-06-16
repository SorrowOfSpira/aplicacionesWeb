<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::orderBy('id', 'desc')->get());
    }

    public function show($id)
    {
        return response()->json(Cliente::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellido'  => 'required|string|max:255',
            'email'     => 'nullable|email|unique:cliente,email',
            'password'  => 'required|min:8',
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente = Cliente::create([
            'nombre'    => $request->nombre,
            'apellido'  => $request->apellido,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'telefono'  => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return response()->json($cliente, 201);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellido'  => 'required|string|max:255',
            'email'     => 'nullable|email|unique:cliente,email,' . $id,
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente->update($request->only(['nombre', 'apellido', 'email', 'telefono', 'direccion']));

        return response()->json($cliente);
    }

    public function destroy($id)
    {
        Cliente::findOrFail($id)->delete();

        return response()->json(['message' => 'Cliente eliminado.']);
    }
}
