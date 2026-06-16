<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Mostrar la lista de usuarios
     */
    public function index() 
    {
        $usuarios = User::orderBy('id', 'desc')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Guardar un nuevo usuario (Create)
     */
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', '¡Integrante sumado al vivero!');
    }

    /**
     * Actualizar los datos (Update)
     * Este es el que recibe los datos del Overlay
     */
    public function update(Request $request, $id) 
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Validamos que el email sea único, pero ignorando el del usuario actual
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Datos actualizados correctamente.');
    }

    /**
     * Eliminar un usuario (Delete)
     */
    public function destroy($id) 
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return back()->with('success', 'Usuario quitado del sistema.');
    }
}