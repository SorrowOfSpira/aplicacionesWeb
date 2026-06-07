<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Panel de Clientes - Vivero</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen py-10 px-4 font-['Inter']">

        <div class="max-w-6xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ url('/dashboard') }}" class="text-[#1B5E20] font-semibold hover:underline flex items-center gap-2 font-['Nunito']">
                    ← Volver al Dashboard
                </a>
            </div>

            <div class="bg-[#FAFAF5] p-8 rounded-xl shadow-sm border border-[#E0E0E0] w-full">

                <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-bold text-[#1B5E20] mb-1 font-['Playfair_Display']">🛒 Gestión de Clientes</h1>
                        <p class="text-[#6B6B6B] font-['Nunito'] text-sm">Administración de clientes registrados</p>
                    </div>
                    <button onclick="openCreateModal()" class="bg-[#1B5E20] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#D84315] transition-all shadow-md">
                        + Nuevo Cliente
                    </button>
                </header>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 shadow-sm animate-fade-in">
                        <ul class="list-disc list-inside text-sm text-red-600 font-['Nunito']">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-[#F1F8E9] border border-[#1B5E20] shadow-sm animate-fade-in flex items-center">
                        <span class="text-[#1B5E20] mr-3 text-xl">🌱</span>
                        <p class="text-[#1B5E20] font-bold font-['Nunito'] text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto rounded-lg border border-[#E0E0E0] bg-white">
                    <table class="w-full text-left border-collapse" id="clientesTable">
                        <thead class="bg-[#F9FBE7]">
                            <tr>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(0)">
                                    <div class="flex items-center gap-1">ID <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(1)">
                                    <div class="flex items-center gap-1">Nombre <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(2)">
                                    <div class="flex items-center gap-1">Email <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span></div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0]">Teléfono</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0]">Dirección</th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E0E0E0]">
                            @foreach($clientes as $cliente)
                            <tr class="hover:bg-[#fcfcf9] transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-[#D84315]">#{{ $cliente->id }}</td>
                                <td class="px-6 py-4 font-semibold text-[#2E2E2E]">{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                                <td class="px-6 py-4 text-[#6B6B6B]">{{ $cliente->email ?? '—' }}</td>
                                <td class="px-6 py-4 text-[#6B6B6B]">{{ $cliente->telefono ?? '—' }}</td>
                                <td class="px-6 py-4 text-[#6B6B6B]">{{ $cliente->direccion ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4">
                                        <button onclick="openEditModal({{ $cliente->id }}, '{{ addslashes($cliente->nombre) }}', '{{ addslashes($cliente->apellido) }}', '{{ $cliente->email }}', '{{ $cliente->telefono }}', '{{ addslashes($cliente->direccion) }}')"
                                            class="text-[#1B5E20] hover:text-[#D84315] text-xs font-bold uppercase tracking-widest transition-all">Editar</button>
                                        <button type="button" onclick="openDeleteModal({{ $cliente->id }}, '{{ addslashes($cliente->nombre) }} {{ addslashes($cliente->apellido) }}')"
                                            class="text-red-400 hover:text-red-600 text-xs font-bold uppercase tracking-widest transition-all">Quitar</button>
                                    </div>
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

        {{-- Modal Crear --}}
        <div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeCreateModal()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-lg rounded-2xl shadow-2xl border border-[#E0E0E0] p-10 animate-fade-in">
                <button onclick="closeCreateModal()" class="absolute top-6 right-6 text-[#1B5E20] hover:scale-110 transition-transform text-2xl font-bold">✕</button>
                <header class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1B5E20] font-['Playfair_Display']">Nuevo Cliente</h2>
                    <p class="text-[#6B6B6B] text-sm font-['Nunito'] mt-2">Registrar cliente en el sistema</p>
                </header>
                <form action="{{ route('clientes.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Nombre</label>
                            <input type="text" name="nombre" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Apellido</label>
                            <input type="text" name="apellido" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Email</label>
                        <input type="email" name="email" class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Contraseña</label>
                        <input type="password" name="password" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Teléfono</label>
                            <input type="text" name="telefono" class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Dirección</label>
                            <input type="text" name="direccion" class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#1B5E20] text-white py-4 rounded-xl font-bold hover:bg-[#D84315] shadow-lg transition-all">Registrar Cliente</button>
                </form>
            </div>
        </div>

        {{-- Modal Editar --}}
        <div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeEditModal()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-lg rounded-2xl shadow-2xl border border-[#E0E0E0] p-10 animate-fade-in">
                <button onclick="closeEditModal()" class="absolute top-6 right-6 text-[#1B5E20] hover:scale-110 transition-transform text-2xl font-bold">✕</button>
                <header class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1B5E20] font-['Playfair_Display']">Actualizar Cliente</h2>
                    <p class="text-[#6B6B6B] text-sm font-['Nunito'] mt-2">Modificando datos del cliente</p>
                </header>
                <form id="editForm" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Nombre</label>
                            <input type="text" id="edit_nombre" name="nombre" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Apellido</label>
                            <input type="text" id="edit_apellido" name="apellido" required class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Email</label>
                        <input type="email" id="edit_email" name="email" class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Teléfono</label>
                            <input type="text" id="edit_telefono" name="telefono" class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Dirección</label>
                            <input type="text" id="edit_direccion" name="direccion" class="w-full border-b-2 border-[#E0E0E0] focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#1B5E20] text-white py-4 rounded-xl font-bold hover:bg-[#D84315] shadow-lg transition-all">Guardar Cambios</button>
                </form>
            </div>
        </div>

        {{-- Modal Eliminar --}}
        <div id="deleteModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-sm rounded-2xl shadow-2xl border border-[#E0E0E0] p-8 text-center animate-fade-in">
                <div class="text-4xl mb-4">⚠️</div>
                <h2 class="text-2xl font-bold text-[#1B5E20] font-['Playfair_Display'] mb-2">¿Eliminar cliente?</h2>
                <p class="text-[#6B6B6B] text-sm font-['Nunito'] mb-8">Estás por quitar a <span id="delete_cliente_name" class="font-bold text-[#1B5E20]"></span>.</p>
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
            let currentSortDir = 'asc';
            function sortTable(columnIndex) {
                const table = document.getElementById("clientesTable");
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.rows);
                currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';
                const sorted = rows.sort((a, b) => {
                    let aVal = a.cells[columnIndex].innerText.trim().replace('#', '');
                    let bVal = b.cells[columnIndex].innerText.trim().replace('#', '');
                    if (!isNaN(aVal) && !isNaN(bVal)) {
                        return currentSortDir === 'asc' ? parseInt(aVal) - parseInt(bVal) : parseInt(bVal) - parseInt(aVal);
                    }
                    return currentSortDir === 'asc' ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
                });
                while (tbody.firstChild) tbody.removeChild(tbody.firstChild);
                tbody.append(...sorted);
            }

            function openCreateModal() {
                document.getElementById('createModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeCreateModal() {
                document.getElementById('createModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function openEditModal(id, nombre, apellido, email, telefono, direccion) {
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_apellido').value = apellido;
                document.getElementById('edit_email').value = email ?? '';
                document.getElementById('edit_telefono').value = telefono ?? '';
                document.getElementById('edit_direccion').value = direccion ?? '';
                document.getElementById('editForm').action = `/clientes/${id}`;
                document.getElementById('editModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function openDeleteModal(id, nombre) {
                document.getElementById('delete_cliente_name').innerText = nombre;
                document.getElementById('deleteForm').action = `/clientes/${id}`;
                document.getElementById('deleteModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') { closeCreateModal(); closeEditModal(); closeDeleteModal(); }
            });
        </script>

        <style>
            .animate-fade-in { animation: fadeIn 0.3s ease-out; }
            @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        </style>
    </body>
</html>
