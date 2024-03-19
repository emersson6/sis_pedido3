@extends('adminlte::page')

@section('title', 'Listado de Pedidos')

@section('content_header')
    <h1>Listado de Pedidos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pedidos Registrados</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Dirección</th>
                    <th>Fecha del Pedido</th>
                    <th>Orden de Compra</th>
                    <th>Estado</th> <!-- Nueva columna para estado -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id }}</td>
                    <td>{{ $pedido->cliente->nombre }}</td>
                    <td>{{ $pedido->direccion->direccion }}</td>
                    <td>{{ $pedido->fecha_pedido }}</td>
                    <td>{{ $pedido->orden_compra }}</td>
                    <td>
                        <select class="form-control change-status" data-pedido-id="{{ $pedido->id }}">
                            <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="completado" {{ $pedido->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </td>
                    <td>
                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-info">Ver Pedido</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.change-status').change(function() {
        var pedidoId = $(this).data('pedido-id');
        var estado = $(this).val();
        $.ajax({
            url: "{{ url('/pedidos/cambiar-estado') }}/" + pedidoId,
            method: 'POST',
            data: {
                estado: estado,
                _token: "{{ csrf_token() }}"
            },
            success: function(result) {
                alert('Estado actualizado con éxito');
            },
            error: function(request, status, error) {
                alert('Error al actualizar el estado');
            }
        });
    });
});
</script>
@endpush

