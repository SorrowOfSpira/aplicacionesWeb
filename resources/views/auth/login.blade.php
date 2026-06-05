<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Iniciar Sesión - {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen flex items-center justify-center font-['Inter']">
        <div class="bg-[#FAFAF5] p-10 rounded-2xl shadow-sm border border-[#E0E0E0] w-full max-w-md mx-4">

            <header class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-[#1B5E20] mb-1 font-['Playfair_Display']">🌱 Vivero</h1>
                <p class="text-[#6B6B6B] text-sm font-['Nunito']">Ingresá tus credenciales para continuar</p>
            </header>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-[#2E2E2E] mb-1">
                        Correo electrónico
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full px-4 py-2.5 border border-[#E0E0E0] rounded-lg text-sm focus:outline-none focus:border-[#1B5E20] focus:ring-1 focus:ring-[#1B5E20] bg-white @error('email') border-red-400 @enderror"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-[#2E2E2E] mb-1">
                        Contraseña
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-2.5 border border-[#E0E0E0] rounded-lg text-sm focus:outline-none focus:border-[#1B5E20] focus:ring-1 focus:ring-[#1B5E20] bg-white"
                    >
                </div>

                <!-- Remember me -->
                <div class="flex items-center gap-2">
                    <input id="remember" type="checkbox" name="remember" class="rounded border-[#E0E0E0] text-[#1B5E20] focus:ring-[#1B5E20]">
                    <label for="remember" class="text-sm text-[#6B6B6B] font-['Nunito']">Recordarme</label>
                </div>

                <button
                    type="submit"
                    class="w-full py-2.5 bg-[#1B5E20] hover:bg-[#154d1a] text-white font-semibold rounded-lg text-sm transition-colors duration-200"
                >
                    Iniciar sesión
                </button>
            </form>

            <footer class="mt-8 pt-6 border-t border-[#E0E0E0] text-center text-[10px] text-[#9E9E9E] font-mono">
                SISTEMA VIVERO v1.0
            </footer>
        </div>
    </body>
</html>
