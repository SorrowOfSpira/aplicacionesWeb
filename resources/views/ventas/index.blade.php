<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ventas - Vivero</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen py-10 px-4 font-['Inter']">

        <div class="max-w-7xl mx-auto">
            <div class="mb-6">
                <a href="{{ url('/dashboard') }}" class="text-[#1B5E20] font-semibold hover:underline flex items-center gap-2 font-['Nunito']">
                    ← Volver al Dashboard
                </a>
            </div>

            <div class="bg-[#FAFAF5] p-8 rounded-xl shadow-sm border border-[#E0E0E0] w-full">

                <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-bold text-[#1B5E20] mb-1 font-['Playfair_Display']">🧾 Registro de Ventas</h1>
                        <p class="text-[#6B6B6B] font-['Nunito'] text-sm">Historial y gestión de ventas del vivero</p>
                    </div>
                    <a href="{{ route('ventas.create') }}"
                        class="bg-[#1B5E20] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#D84315] transition-all shadow-md font-['Nunito']">
                        + Nueva Venta
                    </a>
                </header>

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-[#F1F8E9] border border-[#1B5E20] shadow-sm animate-fade-in flex items-center">
                        <span class="text-[#1B5E20] mr-3 text-xl">🌿</span>
                        <p class="text-[#1B5E20] font-bold font-['Nunito'] text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto rounded-lg border border-[#E0E0E0] bg-white">
                    <table class="w-full text-left border-collapse" id="ventasTable">
                        <thead class="bg-[#F9FBE7]">
                            <tr>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(0)">
                                    <div class="flex items-center gap-1">ID <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(1)">
                                    <div class="flex items-center gap-1">Fecha <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(2)">
                                    <div class="flex items-center gap-1">Cliente <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(3)">
                                    <div class="flex items-center gap-1">Total <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] text-center">Detalle</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E0E0E0]">

                            @foreach($ventas as $venta)
                            <tr class="hover:bg-[#fcfcf9] transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-[#D84315]" data-val="{{ $venta->id }}">#{{ $venta->id }}</td>
                                <td class="px-6 py-4 text-[#6B6B6B]">{{ $venta->fecha }}</td>
                                <td class="px-6 py-4 font-semibold text-[#2E2E2E]">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</td>
                                <td class="px-6 py-4 font-mono text-sm text-[#D84315] font-bold" data-val="{{ $venta->total }}">${{ number_format($venta->total, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="toggleDetalle({{ $venta->id }})"
                                        class="text-xs font-bold uppercase tracking-widest text-[#1B5E20] hover:text-[#D84315] transition-all">
                                        Ver detalle
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4">
                                        <a href="{{ route('ventas.edit', $venta->id) }}"
                                            class="text-[#1B5E20] hover:text-[#D84315] text-xs font-bold uppercase tracking-widest transition-all">Editar</a>
                                        <button type="button" onclick="openDeleteModal({{ $venta->id }}, '#{{ $venta->id }}')"
                                            class="text-red-400 hover:text-red-600 text-xs font-bold uppercase tracking-widest transition-all">Quitar</button>
                                    </div>
                                </td>
                            </tr>
                            <tr id="detalle-{{ $venta->id }}" class="hidden">
                                <td colspan="6" class="px-6 py-4 bg-[#F9FBE7]">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="text-[#1B5E20] font-bold font-['Nunito'] text-xs uppercase tracking-wider">
                                                <th class="pb-2 text-left">Producto</th>
                                                <th class="pb-2 text-left">Cantidad</th>
                                                <th class="pb-2 text-left">Precio Unitario</th>
                                                <th class="pb-2 text-left">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-[#E0E0E0]">
                                            @foreach($venta->detalles as $detalle)
                                            <tr>
                                                <td class="py-2 text-[#2E2E2E]">{{ $detalle->producto->nombre }}</td>
                                                <td class="py-2 text-[#6B6B6B]">{{ $detalle->cantidad }}</td>
                                                <td class="py-2 text-[#6B6B6B]">${{ number_format($detalle->preciounitario, 2) }}</td>
                                                <td class="py-2 font-semibold text-[#D84315]">${{ number_format($detalle->cantidad * $detalle->preciounitario, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <footer class="mt-8 pt-6 border-t border-[#E0E0E0] flex justify-between items-center text-xs text-[#9E9E9E]">
                    <p>Sincronizado con Neon DB</p>
                    <p>Autores: Franco & Ash</p>
                </footer>

            </div>
        </div>

        {{-- Modal Eliminar --}}
        <div id="deleteModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-sm rounded-2xl shadow-2xl border border-[#E0E0E0] p-8 text-center animate-fade-in">
                <div class="text-4xl mb-4">⚠️</div>
                <h2 class="text-2xl font-bold text-[#1B5E20] font-['Playfair_Display'] mb-2">¿Eliminar venta?</h2>
                <p class="text-[#6B6B6B] text-sm font-['Nunito'] mb-8">Estás por eliminar la venta <span id="delete_venta_id" class="font-bold text-[#D84315]"></span>. Esta acción también eliminará sus detalles.</p>
                <div class="flex gap-4">
                    <button onclick="closeDeleteModal()" class="flex-1 bg-[#E0E0E0] py-3 rounded-xl font-bold text-[#6B6B6B]">Cancelar</button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full bg-[#D84315] text-white py-3 rounded-xl font-bold shadow-lg">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function toggleDetalle(id) {
            document.getElementById('detalle-' + id).classList.toggle('hidden');
        }

        function openDeleteModal(id, label) {
            document.getElementById('delete_venta_id').innerText = label;
            document.getElementById('deleteForm').action = `/ventas/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });

        let currentSortDir = 'asc';
        function sortTable(columnIndex) {
            const tbody = document.querySelector('#ventasTable tbody');
            const rows = Array.from(tbody.rows).filter(r => !r.id.startsWith('detalle-'));
            currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';

            rows.sort((a, b) => {
                let aVal = a.cells[columnIndex].dataset.val || a.cells[columnIndex].innerText.trim();
                let bVal = b.cells[columnIndex].dataset.val || b.cells[columnIndex].innerText.trim();
                if (!isNaN(aVal) && !isNaN(bVal)) return currentSortDir === 'asc' ? aVal - bVal : bVal - aVal;
                return currentSortDir === 'asc' ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
            });

            rows.forEach(row => {
                const detalleRow = document.getElementById('detalle-' + row.cells[0].dataset.val);
                tbody.appendChild(row);
                if (detalleRow) tbody.appendChild(detalleRow);
            });
        }
        </script>

        <style>
            .animate-fade-in { animation: fadeIn 0.3s ease-out; }
            @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        </style>
    </body>
</html>
