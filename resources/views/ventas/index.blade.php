<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registro de ventas</title>

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
            <div class="bg-[#FAFAF5] rounded-xl shadow-sm border border-[#E0E0E0] overflow-hidden">

                <div class="p-6 border-b border-[#E0E0E0]">
                    <h1 class="text-3xl font-bold text-[#1B5E20]">
                        Registro de Ventas
                    </h1>
                </div>

                <table class="w-full">
                    <thead class="bg-[#F9FBE7]">
                    <tr>
                        <th class="px-6 py-4 text-left">ID</th>
                        <th class="px-6 py-4 text-left">Fecha</th>
                        <th class="px-6 py-4 text-left">Cliente</th>
                        <th class="px-6 py-4 text-left">Total</th>
                        <th class="px-6 py-4 text-center">Detalle</th>
                    </tr>
                    </thead>
                <tbody>

                @foreach($ventas as $venta)

                <tr class="border-t border-[#E0E0E0]">

                    <td class="px-6 py-4">
                        {{ $venta->id }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $venta->fecha }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}
                    </td>

                    <td class="px-6 py-4">
                        ${{ number_format($venta->total, 2) }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <button
                            onclick="toggleDetalle({{ $venta->id }})"
                            class="text-[#1B5E20] font-semibold">
                            Ver detalle
                        </button>
                    </td>

                </tr>
                <tr id="detalle-{{ $venta->id }}" class="hidden bg-[#F9FBE7]">

                <td colspan="5" class="p-4">

                    <table class="w-full">

                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($venta->detalles as $detalle)

                            <tr>

                                <td>
                                    {{ $detalle->producto->nombre }}
                                </td>

                                <td>
                                    {{ $detalle->cantidad }}
                                </td>

                                <td>
                                    ${{ number_format($detalle->preciounitario,2) }}
                                </td>

                                <td>
                                    ${{ number_format(
                                        $detalle->cantidad * $detalle->preciounitario,
                                        2
                                    ) }}
                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </td>

            </tr>

            @endforeach

            </tbody>
        </div>
        <script>
        function toggleDetalle(id)
        {
            document
                .getElementById('detalle-' + id)
                .classList
                .toggle('hidden');
        }
        </script>
    </body>
</html>