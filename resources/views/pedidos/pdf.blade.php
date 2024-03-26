<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Pedido #{{ $pedido->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Detalle del Pedido: #{{ $pedido->id }}</h1>
    <p><strong>Cliente:</strong> {{ $pedido->cliente->nombre }}</p>
    <p><strong>Dirección de Envío:</strong> {{ $pedido->direccion->direccion }}</p>
    <p><strong>Fecha del Pedido:</strong> {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($pedido->estado) }}</p>
    <p><strong>Comentarios:</strong> {{ $pedido->comentarios ?? 'N/A' }}</p>

    <h4>Items del Pedido</h4>
    <table>
        <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($pedido->items as $item)
            @php
                $subtotal = $item->cantidad * $item->precio_neto;
                $total += $subtotal;
            @endphp
            <tr>
                <td>{{ $item->producto->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>${{ number_format($item->precio_neto, 2) }}</td>
                <td>${{ number_format($subtotal, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="text-center"><strong>Total General</strong></td>
            <td><strong>${{ number_format($total, 2) }}</strong></td>
        </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
