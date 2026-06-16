<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Venta #{{ $venta->id }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|nunito:400,600,700|playfair-display:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F1F8E9] text-[#2E2E2E] antialiased min-h-screen py-10 px-4 font-['Inter']">

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('ventas.index') }}" class="text-[#1B5E20] font-semibold hover:underline font-['Nunito']">
            ← Volver a Ventas
        </a>
    </div>

    <div class="bg-[#FAFAF5] rounded-xl shadow-sm border border-[#E0E0E0] overflow-hidden">

        <div class="p-6 border-b border-[#E0E0E0]">
            <h1 class="text-3xl font-bold text-[#1B5E20] font-['Playfair_Display']">Editar Venta <span class="font-mono text-[#D84315]">#{{ $venta->id }}</span></h1>
        </div>

        <form action="{{ route('ventas.update', $venta->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Fecha y Cliente --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Fecha</label>
                    <input type="date" name="fecha" value="{{ old('fecha', $venta->fecha) }}"
                        class="w-full border border-[#E0E0E0] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#1B5E20]">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Cliente</label>
                    <select name="idcliente"
                        class="w-full border border-[#E0E0E0] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#1B5E20]">
                        <option value="">Seleccionar cliente...</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('idcliente', $venta->idcliente) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->apellido }}, {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Productos --}}
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label class="text-sm font-semibold">Productos</label>
                    <button type="button" onclick="agregarFila()"
                        class="text-sm bg-[#1B5E20] text-white px-3 py-1 rounded-lg hover:bg-[#2E7D32] transition">
                        + Agregar producto
                    </button>
                </div>

                <div id="filas-productos" class="space-y-2">
                    @foreach($venta->detalles as $i => $detalle)
                    <div class="fila-producto grid grid-cols-12 gap-2 items-center">
                        <div class="col-span-5">
                            <select name="productos[{{ $i }}][idproducto]" onchange="cargarPrecio(this)"
                                class="w-full border border-[#E0E0E0] rounded-lg px-3 py-2 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E20]">
                                <option value="">Producto...</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}"
                                        {{ $detalle->idproducto == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <input type="number" name="productos[{{ $i }}][cantidad]" min="1"
                                value="{{ $detalle->cantidad }}"
                                onchange="recalcularFila(this)"
                                class="w-full border border-[#E0E0E0] rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E20]">
                        </div>
                        <div class="col-span-3">
                            <input type="number" name="productos[{{ $i }}][preciounitario]" min="1"
                                value="{{ $detalle->preciounitario }}"
                                onchange="recalcularFila(this)"
                                class="w-full border border-[#E0E0E0] rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E20]">
                        </div>
                        <div class="col-span-2 flex items-center justify-end gap-2">
                            <span class="subtotal text-sm font-semibold text-[#1B5E20]">${{ number_format($detalle->cantidad * $detalle->preciounitario, 0, ',', '.') }}</span>
                            <button type="button" onclick="eliminarFila(this)" class="text-red-400 hover:text-red-600 text-lg leading-none">✕</button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 flex justify-end">
                    <div class="text-lg font-bold text-[#1B5E20]">
                        Total: <span id="total">${{ number_format($venta->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#1B5E20] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#2E7D32] transition">
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const productosData = @json($productos->keyBy('id'));
    let filaIndex = {{ $venta->detalles->count() }};

    function agregarFila() {
        const container = document.getElementById('filas-productos');
        const fila = document.createElement('div');
        fila.className = 'fila-producto grid grid-cols-12 gap-2 items-center';
        fila.innerHTML = `
            <div class="col-span-5">
                <select name="productos[${filaIndex}][idproducto]" onchange="cargarPrecio(this)"
                    class="w-full border border-[#E0E0E0] rounded-lg px-3 py-2 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E20]">
                    <option value="">Producto...</option>
                    ${Object.values(productosData).map(p =>
                        `<option value="${p.id}" data-precio="${p.precio}">${p.nombre}</option>`
                    ).join('')}
                </select>
            </div>
            <div class="col-span-2">
                <input type="number" name="productos[${filaIndex}][cantidad]" placeholder="Cant." min="1" value="1"
                    onchange="recalcularFila(this)"
                    class="w-full border border-[#E0E0E0] rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E20]">
            </div>
            <div class="col-span-3">
                <input type="number" name="productos[${filaIndex}][preciounitario]" placeholder="Precio" min="1"
                    onchange="recalcularFila(this)"
                    class="w-full border border-[#E0E0E0] rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E20]">
            </div>
            <div class="col-span-2 flex items-center justify-end gap-2">
                <span class="subtotal text-sm font-semibold text-[#1B5E20]">$0</span>
                <button type="button" onclick="eliminarFila(this)" class="text-red-400 hover:text-red-600 text-lg leading-none">✕</button>
            </div>
        `;
        container.appendChild(fila);
        filaIndex++;
        actualizarTotal();
    }

    function eliminarFila(btn) {
        btn.closest('.fila-producto').remove();
        actualizarTotal();
    }

    function cargarPrecio(select) {
        const option = select.selectedOptions[0];
        const precio = option?.dataset?.precio ?? '';
        const fila = select.closest('.fila-producto');
        const precioInput = fila.querySelector('input[name*="preciounitario"]');
        precioInput.value = precio ? Math.round(precio) : '';
        recalcularFila(precioInput);
    }

    function recalcularFila(input) {
        const fila = input.closest('.fila-producto');
        const cantidad = parseFloat(fila.querySelector('input[name*="cantidad"]').value) || 0;
        const precio   = parseFloat(fila.querySelector('input[name*="preciounitario"]').value) || 0;
        fila.querySelector('.subtotal').textContent = '$' + (cantidad * precio).toLocaleString('es-AR');
        actualizarTotal();
    }

    function actualizarTotal() {
        const subtotales = [...document.querySelectorAll('.subtotal')]
            .map(el => parseFloat(el.textContent.replace('$', '').replace(/\./g, '').replace(',', '.')) || 0);
        const total = subtotales.reduce((a, b) => a + b, 0);
        document.getElementById('total').textContent = '$' + total.toLocaleString('es-AR');
    }
</script>

</body>
</html>
