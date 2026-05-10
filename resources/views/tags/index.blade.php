<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Categorías - Vivero</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen py-10 px-4 font-['Inter']">
        
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <a href="{{ url('/productos') }}" class="text-[#1B5E20] font-semibold hover:underline flex items-center gap-2 font-['Nunito']">
                    ← Volver a Productos
                </a>
            </div>

            <div class="bg-[#FAFAF5] p-8 rounded-xl shadow-sm border border-[#E0E0E0] w-full">
                
                <header class="text-center mb-10">
                    <h1 class="text-4xl font-bold text-[#1B5E20] mb-2 font-['Playfair_Display']">🏷️ Etiquetas y Categorías</h1>
                    <p class="text-[#6B6B6B] font-['Nunito']">Organiza tus plantas por tipo, cuidado o ubicación</p>
                </header>

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-[#F1F8E9] border border-[#1B5E20] shadow-sm animate-fade-in flex items-center">
                        <span class="text-[#1B5E20] mr-3 text-xl">✅</span>
                        <p class="text-[#1B5E20] font-bold font-['Nunito'] text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="bg-[#F9FBE7] p-6 rounded-lg mb-10 border border-[#E0E0E0]">
                    <h3 class="text-[#1B5E20] font-bold text-sm uppercase tracking-wider mb-4">Nueva Etiqueta</h3>
                    <form action="{{ route('tags.store') }}" method="POST" class="flex gap-4">
                        @csrf
                        <div class="flex-1">
                            <input type="text" name="nombre" placeholder="Ej: Interior, Exterior, Orquídeas..." required 
                                   class="w-full rounded-md border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-[#1B5E20] bg-white text-sm">
                        </div>
                        <button type="submit" class="bg-[#D84315] text-white px-6 py-2 rounded-md font-semibold hover:bg-opacity-90 transition-all text-sm">
                            + Crear
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($tags as $tag)
                    <div class="flex items-center justify-between bg-white p-4 rounded-lg border border-[#E0E0E0] hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <span class="text-[#D84315] font-mono text-xs">#{{ $tag->id }}</span>
                            <span class="font-bold text-[#2E2E2E]">{{ $tag->nombre }}</span>
                        </div>
                        <div class="flex gap-3">
                            <button onclick="openEditLayer({{ $tag->id }}, '{{ $tag->nombre }}')" class="text-[#1B5E20] text-xs font-bold uppercase tracking-tighter hover:underline">Editar</button>
                            <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta etiqueta?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 text-xs font-bold uppercase tracking-tighter hover:text-red-600">Borrar</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="editLayer" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeEditLayer()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-sm rounded-2xl shadow-2xl border border-[#E0E0E0] p-8 animate-fade-in">
                <header class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-[#1B5E20] font-['Playfair_Display']">Editar Etiqueta</h2>
                </header>
                <form id="editForm" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <input type="text" id="edit_nombre" name="nombre" required
                           class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2 text-center">
                    <button type="submit" class="w-full bg-[#1B5E20] text-white py-3 rounded-xl font-bold hover:bg-[#D84315] transition-all">
                        Guardar Cambios
                    </button>
                </form>
            </div>
        </div>

        <script>
            function openEditLayer(id, nombre) {
                document.getElementById('editLayer').classList.remove('hidden');
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('editForm').action = `/tags/${id}`;
            }
            function closeEditLayer() { document.getElementById('editLayer').classList.add('hidden'); }
        </script>
    </body>
</html>