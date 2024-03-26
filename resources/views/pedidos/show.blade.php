@extends('adminlte::page')

@section('title', 'Detalle de Pedido')

@section('content_header')
    <h1>Detalle del Pedido: #{{ $pedido->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Información General</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Cliente:</strong> {{ $pedido->cliente->nombre }}</p>
                <p><strong>Dirección de Envío:</strong> {{ $pedido->direccion->direccion }}</p>
                <p><strong>Fecha del Pedido:</strong> {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Estado:</strong> {{ ucfirst($pedido->estado) }}</p>
                <p><strong>Comentarios:</strong> {{ $pedido->comentarios ?? 'N/A' }}</p>
            </div>
        </div>

        <h4>Items del Pedido</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
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
                        $totalPeso = 0;
                        $totalCajas = 0;
                    @endphp
                    @foreach ($pedido->items as $item)
                        @php
                            $subtotal = $item->cantidad * $item->precio_neto;
                            $total += $subtotal;
                            $totalPeso += $item->cantidad * $item->producto->peso; // Asegúrate de que tu modelo Producto tiene un atributo peso
                            $totalCajas += $item->cantidad;
                        @endphp
                        <tr>
                            <td>{{ $item->producto->nombre }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>${{ number_format($item->precio_neto, 2) }}</td>
                            <td>${{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 text-center">
                <i class="fas fa-boxes fa-2x"></i>
                <h5>Total Cajas: {{ $totalCajas }}</h5>
            </div>
            <div class="col-md-4 text-center">
                <i class="fas fa-weight-hanging fa-2x"></i>
                <h5>Total Peso: {{ $totalPeso }} kg</h5>
            </div>
            <div class="col-md-4 text-center">
                <i class="fas fa-dollar-sign fa-2x"></i>
                <h5>Total General: ${{ number_format($total, 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="card-footer text-center">
        <a href="{{ route('pedidos.index') }}" class="btn btn-primary">Volver a la lista de pedidos</a>
    </div>
    <div class="card-footer text-center">
        <a href="{{ route('pedidos.pdf', $pedido->id) }}" class="btn btn-success">Descargar PDF</a>
    </div>
</div>
@stop
