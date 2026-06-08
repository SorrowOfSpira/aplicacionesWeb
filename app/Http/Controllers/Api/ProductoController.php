<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::with('tags')->orderBy('id', 'desc')->get());
    }

    public function show($id)
    {
        return response()->json(Producto::with('tags')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'nombre_cientifico' => 'nullable|string|max:255',
            'precio'            => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'tags'              => 'nullable|array',
            'tags.*'            => 'exists:tags,id',
            'imagen'            => 'nullable|image|max:2048',
        ]);

        $imagenUrl = null;

        if ($request->hasFile('imagen')) {
            $cloud_name    = 'dbiivmucu';
            $upload_preset = 'productos_vivero';
            $imagen        = $request->file('imagen')->getRealPath();
            $url           = "https://api.cloudinary.com/v1_1/$cloud_name/image/upload";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'file'          => new \CURLFile($imagen),
                'upload_preset' => $upload_preset,
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = json_decode(curl_exec($ch), true);
            curl_close($ch);

            $imagenUrl = $data['secure_url'] ?? null;
        }

        $producto = Producto::create([
            'nombre'            => $request->nombre,
            'nombre_cientifico' => $request->nombre_cientifico,
            'precio'            => $request->precio,
            'stock'             => $request->stock,
            'img_url'           => $imagenUrl,
        ]);

        if ($request->has('tags')) {
            $producto->tags()->sync($request->tags);
        }

        return response()->json($producto->load('tags'), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'nombre_cientifico' => 'nullable|string|max:255',
            'precio'            => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'tags'              => 'nullable|array',
            'tags.*'            => 'exists:tags,id',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->only(['nombre', 'nombre_cientifico', 'precio', 'stock']));
        $producto->tags()->sync($request->get('tags', []));

        return response()->json($producto->load('tags'));
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->tags()->detach();
        $producto->delete();

        return response()->json(['message' => 'Producto eliminado.']);
    }
}
