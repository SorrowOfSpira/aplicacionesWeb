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
        $productos = Producto::with('tags')->orderBy('id', 'desc')->get();
        
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
            'stock' => 'required|integer|min:0',
            'tags' => 'nullable|array',
            'img_url' => 'nullable|image|max:2048'
        ]);

        $imagenUrl = null;

        if ($request->hasFile('imagen')) {

            $cloud_name = 'dbiivmucu';
            $upload_preset = 'productos_vivero';

            $imagen = $request->file('imagen')->getRealPath();

            $url = "https://api.cloudinary.com/v1_1/$cloud_name/image/upload";

            $postFields = [
                'file' => new \CURLFile($imagen),
                'upload_preset' => $upload_preset
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            curl_close($ch);

            $data = json_decode($response, true);

            $imagenUrl = $data['secure_url'];
}

        // 2. Creamos el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'nombre_cientifico' => $request->nombre_cientifico,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'img_url' => $imagenUrl
        ]);

        // 3. Guardamos la relación en la tabla pivote
        if ($request->has('tags')) {
            $producto->tags()->sync($request->tags);
        }

        return redirect()->route('productos.index')->with('success', '¡Producto agregado al stock con éxito!');
    }
    public function update(Request $request, $id)
    {
        // 1. Validamos (incluyendo los tags)
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_cientifico' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'tags' => 'nullable|array'
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->only('nombre', 'nombre_cientifico', 'precio', 'stock'));

        $producto->tags()->sync($request->get('tags', []));

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->tags()->detach();
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado del inventario');
    }
}