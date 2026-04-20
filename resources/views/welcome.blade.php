<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bienvenido - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />

        <!-- Carga de Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen flex items-center justify-center font-['Inter']">
        <div class="text-center bg-[#FAFAF5] p-10 rounded-xl shadow-sm border border-[#E0E0E0] max-w-lg w-full">
            <h1 class="text-4xl font-bold text-[#1B5E20] mb-2 font-['Playfair_Display']">🌱 Vivero</h1>
            <p class="text-[#6B6B6B] mb-8 font-['Nunito']">Gestión de panel administrativo</p>
            
            <a href="{{ route('dashboard') }}" class="inline-block bg-[#D84315] text-white px-6 py-3 rounded-md font-semibold hover:bg-opacity-90 transition-all">
                Ir al Dashboard
            </a>
        </div>
    </body>
</html>
