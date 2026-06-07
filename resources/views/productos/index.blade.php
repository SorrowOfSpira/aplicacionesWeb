<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inventario - Vivero</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen py-10 px-4 font-['Inter']">
        
        <div class="max-w-7xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ url('/dashboard') }}" class="text-[#1B5E20] font-semibold hover:underline flex items-center gap-2 font-['Nunito']">
                    ← Volver al Dashboard
                </a>
            </div>

            <div class="bg-[#FAFAF5] p-8 rounded-xl shadow-sm border border-[#E0E0E0] w-full">
                
                <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-bold text-[#1B5E20] mb-2 font-['Playfair_Display']">🌱 Gestión de Inventario</h1>
                        <p class="text-[#6B6B6B] font-['Nunito'] text-sm">Administración de stock y catálogo del vivero</p>
                    </div>
                    <button onclick="openCreateModal()" class="bg-[#1B5E20] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#D84315] transition-all shadow-md">
                        + Registrar Producto
                    </button>
                </header>

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-[#F1F8E9] border border-[#1B5E20] shadow-sm animate-fade-in flex items-center">
                        <span class="text-[#1B5E20] mr-3 text-xl">🌿</span>
                        <p class="text-[#1B5E20] font-bold font-['Nunito'] text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto rounded-lg border border-[#E0E0E0] bg-white">
                    <table class="w-full text-left border-collapse" id="productosTable">
                        <thead class="bg-[#F9FBE7]">
                            <tr>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(0)">
                                    <div class="flex items-center gap-1">ID <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold border-b border-[#E0E0E0]">Imagen</th>

                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(2)">
                                    <div class="flex items-center gap-1">Producto <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(3)">
                                    <div class="flex items-center gap-1">Científico <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(4)">
                                    <div class="flex items-center gap-1">Precio <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0]">Etiquetas</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E0E0E0]">
                            @foreach($productos as $producto)
                            <tr class="hover:bg-[#fcfcf9] transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-[#D84315]" data-val="{{ $producto->id }}">#{{ $producto->id }}</td>
                                <td class="px-6 py-4">
                                    @if($producto->img_url)
                                        <img src="{{ $producto->img_url }}" class="w-14 h-14 object-cover rounded-lg shadow-sm border border-[#E0E0E0] bg-white">
                                    @else
                                        <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs border border-dashed border-gray-300">
                                            Sin foto
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-semibold text-[#2E2E2E]">{{ $producto->nombre }}</td>
                                <td class="px-6 py-4 text-xs italic text-[#6B6B6B]">{{ $producto->nombre_cientifico ?? 'N/A' }}</td>
                                <td class="px-6 py-4 font-mono text-sm text-[#D84315] font-bold" data-val="{{ $producto->precio }}">${{ number_format($producto->precio, 2) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($producto->tags as $tag)
                                            <span class="text-[9px] px-2 py-0.5 bg-[#F1F8E9] border border-[#1B5E20]/20 text-[#1B5E20] rounded-full uppercase font-bold tracking-tighter">{{ $tag->nombre }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4">
                                        <button onclick='openEditLayer({{ $producto->id }}, "{{ $producto->nombre }}", "{{ $producto->nombre_cientifico }}", {{ $producto->precio }}, @json($producto->tags->pluck("id")))'
                                            class="text-[#1B5E20] hover:text-[#D84315] text-xs font-bold uppercase tracking-widest transition-all">Editar</button>
                                        <button type="button" onclick="openDeleteModal({{ $producto->id }}, '{{ $producto->nombre }}')" 
                                            class="text-red-400 hover:text-red-600 text-xs font-bold uppercase tracking-widest transition-all">Quitar</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeCreateModal()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-2xl rounded-2xl shadow-2xl border border-[#E0E0E0] p-10 overflow-y-auto max-h-[90vh] animate-fade-in">
                <button onclick="closeCreateModal()" class="absolute top-6 right-6 text-[#1B5E20] hover:scale-110 transition-transform text-2xl font-bold">✕</button>
                <header class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1B5E20] font-['Playfair_Display']">Nuevo Producto</h2>
                </header>
                <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Nombre Común</label>
                            <input type="text" name="nombre" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent py-2">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Nombre Científico</label>
                            <input type="text" name="nombre_cientifico" class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent py-2">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Precio ($)</label>
                            <input type="number" step="0.01" name="precio" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent py-2">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Imagen del Producto</label>
                            <input type="file" name="imagen" class="w-full text-xs text-[#6B6B6B] mt-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-3 ml-1">Categorías</label>
                        <div class="flex flex-wrap gap-3 p-4 bg-white/50 rounded-xl border border-[#E0E0E0]">
                            @foreach($tags as $tag)
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded text-[#1B5E20]">
                                <span class="ml-2 text-xs text-[#6B6B6B]">{{ $tag->nombre }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#1B5E20] text-white py-4 rounded-xl font-bold hover:bg-[#D84315] shadow-lg transition-all">Registrar Producto</button>
                </form>
            </div>
        </div>

        <div id="editLayer" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeEditLayer()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-lg rounded-2xl shadow-2xl border border-[#E0E0E0] p-10 overflow-y-auto max-h-[90vh] animate-fade-in">
                <button onclick="closeEditLayer()" class="absolute top-6 right-6 text-[#1B5E20] hover:scale-110 transition-transform text-2xl font-bold">✕</button>
                <header class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1B5E20] font-['Playfair_Display']">Editar Producto</h2>
                </header>
                <form id="editForm" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1">Nombre Comercial</label>
                        <input type="text" id="edit_nombre" name="nombre" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent py-2">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1">Nombre Científico</label>
                        <input type="text" id="edit_nombre_cientifico" name="nombre_cientifico" class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent py-2">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1">Precio Actual</label>
                        <input type="number" step="0.01" id="edit_precio" name="precio" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent py-2 text-[#D84315] font-mono">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-2">Actualizar Categorías</label>
                        <div class="flex flex-wrap gap-2 p-3 bg-white/50 rounded-lg border border-[#E0E0E0]">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="edit-tag-checkbox rounded text-[#1B5E20]">
                                    <span class="ml-2 text-xs text-[#6B6B6B]">{{ $tag->nombre }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#1B5E20] text-white py-4 rounded-xl font-bold hover:bg-[#D84315] shadow-lg transition-all">Guardar Cambios</button>
                </form>
            </div>
        </div>

        <div id="deleteModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-sm rounded-2xl shadow-2xl border border-[#E0E0E0] p-8 text-center animate-fade-in">
                <div class="text-4xl mb-4">⚠️</div>
                <h2 class="text-2xl font-bold text-[#1B5E20] font-['Playfair_Display'] mb-2">¿Quitar producto?</h2>
                <p class="text-[#6B6B6B] text-sm font-['Nunito'] mb-8">Estás por eliminar <span id="delete_item_name" class="font-bold text-[#1B5E20]"></span>.</p>
                <div class="flex gap-4">
                    <button onclick="closeDeleteModal()" class="flex-1 bg-[#E0E0E0] py-3 rounded-xl font-bold">Cancelar</button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full bg-[#D84315] text-white py-3 rounded-xl font-bold shadow-lg">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Lógica de Ordenamiento JS (Ajustada para los nuevos índices de columna)
            let currentSortDir = 'asc';
            function sortTable(columnIndex) {
                const tbody = document.querySelector("#productosTable tbody");
                const rows = Array.from(tbody.rows);
                currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';

                rows.sort((a, b) => {
                    let aText = a.cells[columnIndex].dataset.val || a.cells[columnIndex].innerText.trim();
                    let bText = b.cells[columnIndex].dataset.val || b.cells[columnIndex].innerText.trim();
                    
                    if (!isNaN(aText) && !isNaN(bText)) return currentSortDir === 'asc' ? aText - bText : bText - aText;
                    return currentSortDir === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
                });
                tbody.append(...rows);
            }

            // Lógica Modales
            function openCreateModal() { document.getElementById('createModal').classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
            function closeCreateModal() { document.getElementById('createModal').classList.add('hidden'); document.body.style.overflow = 'auto'; }
            function openEditLayer(id, nombre, cientifico, precio, selectedTags) {
                document.getElementById('editLayer').classList.remove('hidden');
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_nombre_cientifico').value = (cientifico === 'null' || !cientifico) ? '' : cientifico;
                document.getElementById('edit_precio').value = precio;
                document.querySelectorAll('.edit-tag-checkbox').forEach(cb => cb.checked = selectedTags.includes(parseInt(cb.value)));
                document.getElementById('editForm').action = `/productos/${id}`;
                document.body.style.overflow = 'hidden';
            }
            function closeEditLayer() { document.getElementById('editLayer').classList.add('hidden'); document.body.style.overflow = 'auto'; }
            function openDeleteModal(id, nombre) {
                document.getElementById('delete_item_name').innerText = nombre;
                document.getElementById('deleteForm').action = `/productos/${id}`;
                document.getElementById('deleteModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeDeleteModal() { document.getElementById('deleteModal').classList.add('hidden'); document.body.style.overflow = 'auto'; }
        </script>

        <style> .animate-fade-in { animation: fadeIn 0.3s ease-out; } @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } } </style>
    </body>
</html>