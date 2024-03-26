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
            <div class="card-tools">
            <!-- Botón para descargar pedidos -->
            <div class="card-body"><a href="{{ route('pedidos.descargar') }}" class="btn btn-success">
                Descargar Pedidos
            </a></div>
        </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="pedidosTable">
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
                        <select class="form-control change-status" data-pedido-id="{{ $pedido->id }}" data-url-base="{{ route('pedidos.cambiarEstado', '_id_') }}">
                            <option value="pendiente" {{ $pedido->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="completado" {{ $pedido->status == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado" {{ $pedido->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
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

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endpush

@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#pedidosTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        }
    });

    $('.change-status').change(function() {
    var pedidoId = $(this).data('pedido-id');
    var status = $(this).val(); // Cambiar 'estado' por 'status'
    $.ajax({
        url: "{{ route('pedidos.cambiarEstado', '') }}/" + pedidoId,
        method: 'POST',
        data: {
            status: status, // Cambiar 'estado' por 'status'
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

