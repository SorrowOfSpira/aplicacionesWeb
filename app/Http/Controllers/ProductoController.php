<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos y el formulario de registro
     */
    public function index()
    {
        // Traemos los productos con sus tags para la tabla
        $productos = Producto::with('tags')->get();
        
        // IMPORTANTE: Traemos los tags para que aparezcan los checkboxes en el formulario
        $tags = Tag::all(); 

        return view('productos.index', compact('productos', 'tags'));
    }

    /**
     * Guarda el producto en la base de datos
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_cientifico' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
            'tags' => 'nullable|array' // Cambié a nullable por si algún producto no tiene tags
        ]);

        // 2. Creamos el producto
        $producto = Producto::create($request->only('nombre', 'nombre_cientifico', 'precio'));

        // 3. Guardamos la relación en la tabla pivote
        if ($request->has('tags')) {
            $producto->tags()->sync($request->tags);
        }

        return redirect()->route('productos.index')->with('success', '¡Producto agregado al stock con éxito!');
    }

    /**
     * Actualiza el producto (Para el Layer flotante de edición)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_cientifico' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->only('nombre', 'nombre_cientifico', 'precio'));

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Elimina el producto
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->tags()->detach(); // Borramos la relación en la tabla pivote primero
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado del inventario');
    }
}