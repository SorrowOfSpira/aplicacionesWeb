<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Panel de Inventario - Vivero</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen py-10 px-4 font-['Inter']">
        
        <div class="max-w-6xl mx-auto">
            <div class="mb-6">
                <a href="{{ url('/dashboard') }}" class="text-[#1B5E20] font-semibold hover:underline flex items-center gap-2 font-['Nunito']">
                    ← Volver al Dashboard
                </a>
            </div>

            <div class="bg-[#FAFAF5] p-8 rounded-xl shadow-sm border border-[#E0E0E0] w-full">
                
                <header class="text-center mb-10">
                    <h1 class="text-4xl font-bold text-[#1B5E20] mb-2 font-['Playfair_Display']">🌱 Gestión de Inventario</h1>
                    <p class="text-[#6B6B6B] font-['Nunito']">Administración de plantas, herramientas y productos del vivero</p>
                </header>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 shadow-sm animate-fade-in">
                        <div class="flex items-center mb-2">
                            <span class="text-red-600 mr-2">⚠️</span>
                            <h3 class="text-red-800 font-bold text-sm uppercase">Error en los datos:</h3>
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-600 font-['Nunito']">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-[#F1F8E9] border border-[#1B5E20] shadow-sm animate-fade-in flex items-center">
                        <span class="text-[#1B5E20] mr-3 text-xl">🌿</span>
                        <p class="text-[#1B5E20] font-bold font-['Nunito'] text-sm">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                <div class="bg-[#F9FBE7] p-6 rounded-lg mb-10 border border-[#E0E0E0]">
                    <h3 class="text-[#1B5E20] font-bold text-sm uppercase tracking-wider mb-4">Registrar Nuevo Producto</h3>
                    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1">Nombre Común</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" required 
                                       class="w-full rounded-md border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-[#1B5E20] bg-white text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1">Nombre Científico</label>
                                <input type="text" name="nombre_cientifico" value="{{ old('nombre_cientifico') }}"
                                       class="w-full rounded-md border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-[#1B5E20] bg-white text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1">Precio ($)</label>
                                <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" required 
                                       class="w-full rounded-md border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-[#1B5E20] bg-white text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1">
                                    Imagen
                                </label>

                                <input type="file" name="imagen"
                                    class="w-full text-sm">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-2">Categorías / Etiquetas</label>
                            <div class="flex flex-wrap gap-3 p-3 bg-white rounded-md border border-[#E0E0E0]">
                                @foreach($tags as $tag)
                                <label class="inline-flex items-center group cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded border-[#E0E0E0] text-[#1B5E20] focus:ring-[#1B5E20]">
                                    <span class="ml-2 text-xs text-[#6B6B6B] group-hover:text-[#1B5E20] transition-colors">{{ $tag->nombre }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-[#D84315] text-white px-6 py-2 rounded-md font-semibold hover:bg-opacity-90 transition-all text-sm shadow-sm">
                                + Agregar al Stock
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto rounded-lg border border-[#E0E0E0] bg-white">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-[#F9FBE7]">
                            <tr>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0]">Producto</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0]">Científico</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0]">Precio</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0]">Etiquetas</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold"> Imagen</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E0E0E0]">
                            @foreach($productos as $producto)
                            <tr class="hover:bg-[#fcfcf9] transition-colors">
                                <td class="px-6 py-4 font-semibold text-[#2E2E2E]">{{ $producto->nombre }}</td>
                                <td class="px-6 py-4 text-xs italic text-[#6B6B6B]">{{ $producto->nombre_cientifico ?? 'N/A' }}</td>
                                <td class="px-6 py-4 font-mono text-sm text-[#D84315] font-bold">${{ number_format($producto->precio, 2) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($producto->tags as $tag)
                                            <span class="text-[9px] px-2 py-0.5 bg-[#F1F8E9] border border-[#1B5E20]/20 text-[#1B5E20] rounded-full uppercase font-bold tracking-tighter">
                                                {{ $tag->nombre }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($producto->img_url)
                                        <img src="{{ $producto->img_url }}"
                                            class="w-20 h-20 object-cover rounded-lg">
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4">
                                        <button 
                                            onclick="openEditLayer({{ $producto->id }}, '{{ $producto->nombre }}', '{{ $producto->nombre_cientifico }}', {{ $producto->precio }})"
                                            class="text-[#1B5E20] hover:text-[#D84315] text-xs font-bold uppercase tracking-widest transition-all">
                                            Editar
                                        </button>
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Eliminar producto?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 text-xs font-bold uppercase tracking-widest transition-all">
                                                Quitar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <footer class="mt-8 pt-6 border-t border-[#E0E0E0] flex justify-between items-center text-xs text-[#9E9E9E]">
                    <p>Sincronizado con Neon DB</p>
                    <p>Inventario Vivero v1.0</p>
                </footer>
            </div>
        </div>

        <div id="editLayer" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeEditLayer()"></div>
            
            <div class="relative bg-[#FAFAF5] w-full max-w-lg rounded-2xl shadow-2xl border border-[#E0E0E0] p-10 overflow-hidden animate-fade-in">
                <button onclick="closeEditLayer()" class="absolute top-6 right-6 text-[#1B5E20] hover:scale-110 transition-transform">
                    <span class="text-2xl font-bold">✕</span>
                </button>

                <header class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1B5E20] font-['Playfair_Display']">Actualizar Producto</h2>
                    <p class="text-[#6B6B6B] text-sm font-['Nunito'] mt-2">Modificando ficha técnica en stock</p>
                </header>
                
                <form id="editForm" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Nombre Comercial</label>
                        <input type="text" id="edit_nombre" name="nombre" required
                               class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Nombre Científico</label>
                        <input type="text" id="edit_nombre_cientifico" name="nombre_cientifico"
                               class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Precio Actual</label>
                        <input type="number" step="0.01" id="edit_precio" name="precio" required
                               class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2 text-[#D84315] font-mono">
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full bg-[#1B5E20] text-white py-4 rounded-xl font-bold hover:bg-[#D84315] shadow-lg transition-all">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openEditLayer(id, nombre, cientifico, precio) {
                const layer = document.getElementById('editLayer');
                layer.classList.remove('hidden');

                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_nombre_cientifico').value = (cientifico === 'null' || !cientifico) ? '' : cientifico;
                document.getElementById('edit_precio').value = precio;
                
                document.getElementById('editForm').action = `/productos/${id}`;
                document.body.style.overflow = 'hidden';
            }

            function closeEditLayer() {
                const layer = document.getElementById('editLayer');
                layer.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeEditLayer();
            });
        </script>

        <style>
            .animate-fade-in { animation: fadeIn 0.3s ease-out; }
            @keyframes fadeIn {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }
        </style>
    </body>
</html>