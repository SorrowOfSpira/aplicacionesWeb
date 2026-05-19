<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Panel de Personal - Vivero</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen py-10 px-4 font-['Inter']">
        
        <div class="max-w-5xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ url('/dashboard') }}" class="text-[#1B5E20] font-semibold hover:underline flex items-center gap-2 font-['Nunito']">
                    ← Volver al Dashboard
                </a>
            </div>

            <div class="bg-[#FAFAF5] p-8 rounded-xl shadow-sm border border-[#E0E0E0] w-full">
                
                <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-bold text-[#1B5E20] mb-1 font-['Playfair_Display']">🌱 Gestión de Personal</h1>
                        <p class="text-[#6B6B6B] font-['Nunito'] text-sm">Administración de usuarios y accesos al sistema</p>
                    </div>
                    <button onclick="openCreateModal()" class="bg-[#1B5E20] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#D84315] transition-all shadow-md">
                        + Nuevo Integrante
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
                    <table class="w-full text-left border-collapse" id="usuariosTable">
                        <thead class="bg-[#F9FBE7]">
                            <tr>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(0)">
                                    <div class="flex items-center gap-1">
                                        ID <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(1)">
                                    <div class="flex items-center gap-1">
                                        Nombre <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] cursor-pointer hover:bg-[#F1F8E9] transition-colors group" onclick="sortTable(2)">
                                    <div class="flex items-center gap-1">
                                        Email <span class="text-[10px] opacity-30 group-hover:opacity-100">↕</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-[#1B5E20] font-bold font-['Nunito'] border-b border-[#E0E0E0] text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E0E0E0]">
                            @foreach($usuarios as $user)
                            <tr class="hover:bg-[#fcfcf9] transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-[#D84315]">#{{ $user->id }}</td>
                                <td class="px-6 py-4 font-semibold text-[#2E2E2E]">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-[#6B6B6B]">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4">
                                        <button onclick="openEditLayer({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')"
                                            class="text-[#1B5E20] hover:text-[#D84315] text-xs font-bold uppercase tracking-widest transition-all">Editar</button>
                                        <button type="button" onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')" 
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

        <div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeCreateModal()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-lg rounded-2xl shadow-2xl border border-[#E0E0E0] p-10 animate-fade-in">
                <button onclick="closeCreateModal()" class="absolute top-6 right-6 text-[#1B5E20] hover:scale-110 transition-transform text-2xl font-bold">✕</button>
                <header class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1B5E20] font-['Playfair_Display']">Nuevo Integrante</h2>
                    <p class="text-[#6B6B6B] text-sm font-['Nunito'] mt-2">Registrar acceso al sistema</p>
                </header>
                <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Nombre Completo</label>
                        <input type="text" name="name" required class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Correo Institucional</label>
                        <input type="email" name="email" required class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Contraseña Temporal</label>
                        <input type="password" name="password" required class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>
                    <button type="submit" class="w-full bg-[#1B5E20] text-white py-4 rounded-xl font-bold hover:bg-[#D84315] shadow-lg transition-all">Registrar Integrante</button>
                </form>
            </div>
        </div>

        <div id="editLayer" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeEditLayer()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-lg rounded-2xl shadow-2xl border border-[#E0E0E0] p-10 animate-fade-in">
                <button onclick="closeEditLayer()" class="absolute top-6 right-6 text-[#1B5E20] hover:scale-110 transition-transform text-2xl font-bold">✕</button>
                <header class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1B5E20] font-['Playfair_Display']">Actualizar Datos</h2>
                    <p class="text-[#6B6B6B] text-sm font-['Nunito'] mt-2">Modificando registro de personal</p>
                </header>
                <form id="editForm" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Nombre Completo</label>
                        <input type="text" id="edit_name" name="name" required class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#1B5E20] uppercase mb-1 ml-1">Correo Institucional</label>
                        <input type="email" id="edit_email" name="email" required class="w-full border-b-2 border-[#E0E0E0] border-t-0 border-l-0 border-r-0 focus:border-[#1B5E20] focus:ring-0 bg-transparent text-lg py-2">
                    </div>
                    <button type="submit" class="w-full bg-[#1B5E20] text-white py-4 rounded-xl font-bold hover:bg-[#D84315] shadow-lg transition-all">Guardar Cambios</button>
                </form>
            </div>
        </div>

        <div id="deleteModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[#F1F8E9]/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
            <div class="relative bg-[#FAFAF5] w-full max-w-sm rounded-2xl shadow-2xl border border-[#E0E0E0] p-8 text-center animate-fade-in">
                <div class="text-4xl mb-4">⚠️</div>
                <h2 class="text-2xl font-bold text-[#1B5E20] font-['Playfair_Display'] mb-2">¿Eliminar usuario?</h2>
                <p class="text-[#6B6B6B] text-sm font-['Nunito'] mb-8">Estás por quitar a <span id="delete_user_name" class="font-bold text-[#1B5E20]"></span>.</p>
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
            // Lógica de Ordenamiento Interactiva
            let currentSortDir = 'asc';
            function sortTable(columnIndex) {
                const table = document.getElementById("usuariosTable");
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.rows);

                // Alternar dirección
                currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';

                const sortedRows = rows.sort((a, b) => {
                    let aColText = a.cells[columnIndex].innerText.trim().replace('#', '');
                    let bColText = b.cells[columnIndex].innerText.trim().replace('#', '');

                    // Lógica para números (ID)
                    if (!isNaN(aColText) && !isNaN(bColText)) {
                        return currentSortDir === 'asc' 
                            ? parseInt(aColText) - parseInt(bColText) 
                            : parseInt(bColText) - parseInt(aColText);
                    }

                    // Lógica para texto
                    return currentSortDir === 'asc' 
                        ? aColText.localeCompare(bColText) 
                        : bColText.localeCompare(aColText);
                });

                // Re-insertar filas ordenadas
                while (tbody.firstChild) {
                    tbody.removeChild(tbody.firstChild);
                }
                tbody.append(...sortedRows);
            }

            // Lógica de Modales
            function openCreateModal() {
                document.getElementById('createModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeCreateModal() {
                document.getElementById('createModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
            function openEditLayer(id, name, email) {
                document.getElementById('editLayer').classList.remove('hidden');
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('editForm').action = `/usuarios/${id}`;
                document.body.style.overflow = 'hidden';
            }
            function closeEditLayer() {
                document.getElementById('editLayer').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
            function openDeleteModal(id, name) {
                document.getElementById('delete_user_name').innerText = name;
                document.getElementById('deleteForm').action = `/usuarios/${id}`;
                document.getElementById('deleteModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') { closeCreateModal(); closeEditLayer(); closeDeleteModal(); }
            });
        </script>

        <style>
            .animate-fade-in { animation: fadeIn 0.3s ease-out; }
            @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        </style>
    </body>
</html>