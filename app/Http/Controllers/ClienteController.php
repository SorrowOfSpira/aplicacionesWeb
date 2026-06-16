<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('id', 'desc')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email'    => 'nullable|email|unique:cliente,email',
            'password' => 'required|min:8',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        Cliente::create([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return back()->with('success', '¡Cliente registrado correctamente!');
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email'    => 'nullable|email|unique:cliente,email,' . $id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente->update($request->only(['nombre', 'apellido', 'email', 'telefono', 'direccion']));

        return back()->with('success', 'Datos del cliente actualizados.');
    }

    public function destroy($id)
    {
        Cliente::findOrFail($id)->delete();
        return back()->with('success', 'Cliente eliminado del sistema.');
    }
}
