<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::orderBy('id', 'desc')->get());
    }

    public function show($id)
    {
        return response()->json(Tag::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tags,nombre',
        ]);

        $tag = Tag::create($request->only('nombre'));

        return response()->json($tag, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tags,nombre,' . $id,
        ]);

        $tag = Tag::findOrFail($id);
        $tag->update($request->only('nombre'));

        return response()->json($tag);
    }

    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();

        return response()->json(['message' => 'Tag eliminado.']);
    }
}
