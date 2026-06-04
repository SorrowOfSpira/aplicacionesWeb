<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />

        <!-- Carga de Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen flex items-center justify-center font-['Inter']">
        <div class="text-center bg-[#FAFAF5] p-10 rounded-2xl shadow-sm border border-[#E0E0E0] max-w-2xl w-full mx-4">
            
            <header class="mb-10">
                <h1 class="text-4xl font-bold text-[#1B5E20] mb-2 font-['Playfair_Display']">🌱 Panel de Control</h1>
                <p class="text-[#6B6B6B] font-['Nunito']">Bienvenido al sistema de gestión del Vivero</p>
            </header>

            <!-- Grid de Navegación -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Botón Productos -->
                <a href="{{ route('productos.index') }}" class="group p-6 bg-white border border-[#E0E0E0] rounded-xl hover:border-[#1B5E20] hover:shadow-md transition-all duration-300">
                    <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🌿</div>
                    <h3 class="font-bold text-[#1B5E20] font-['Nunito']">Productos</h3>
                    <p class="text-[10px] text-[#9E9E9E] uppercase mt-1 tracking-widest">Inventario</p>
                </a>

                <!-- Botón Etiquetas (Tags) -->
                <a href="{{ route('tags.index') }}" class="group p-6 bg-white border border-[#E0E0E0] rounded-xl hover:border-[#1B5E20] hover:shadow-md transition-all duration-300">
                    <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🏷️</div>
                    <h3 class="font-bold text-[#1B5E20] font-['Nunito']">Categorías</h3>
                    <p class="text-[10px] text-[#9E9E9E] uppercase mt-1 tracking-widest">Etiquetas</p>
                </a>

                <!-- Botón Usuarios -->
                <a href="{{ route('usuarios.index') }}" class="group p-6 bg-white border border-[#E0E0E0] rounded-xl hover:border-[#1B5E20] hover:shadow-md transition-all duration-300">
                    <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">👥</div>
                    <h3 class="font-bold text-[#1B5E20] font-['Nunito']">Personal</h3>
                    <p class="text-[10px] text-[#9E9E9E] uppercase mt-1 tracking-widest">Accesos</p>
                </a>

                <!-- Botón Ventas -->
                <a href="{{ route('ventas.index') }}" class="group p-6 bg-white border border-[#E0E0E0] rounded-xl hover:border-[#1B5E20] hover:shadow-md transition-all duration-300">
                    <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🛒</div>
                    <h3 class="font-bold text-[#1B5E20] font-['Nunito']">Ventas</h3>
                    <p class="text-[10px] text-[#9E9E9E] uppercase mt-1 tracking-widest">Registro</p>
                </a>

            </div>

            <footer class="mt-12 pt-6 border-t border-[#E0E0E0] text-[10px] text-[#9E9E9E] font-mono">
                SISTEMA VIVERO v1.0 | NEON DB CONNECTED
            </footer>
        </div>
    </body>
</html>