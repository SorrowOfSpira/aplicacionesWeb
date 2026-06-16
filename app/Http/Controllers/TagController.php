<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->get();
        return view('tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tags,nombre',
        ]);

        Tag::create($request->only('nombre'));

        return redirect()->route('tags.index')->with('success', '¡Nueva etiqueta creada!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->update($request->only('nombre'));

        return redirect()->route('tags.index')->with('success', 'Etiqueta actualizada');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        // Al borrar un tag, Laravel automáticamente limpia la tabla pivote si usaste onDelete('cascade')
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Etiqueta eliminada');
    }
}