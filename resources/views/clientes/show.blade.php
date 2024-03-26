@extends('adminlte::page')

@section('title', 'Detalle del Cliente')

@section('content_header')
    <h1>Detalle del Cliente</h1>
@stop

@section('content')
{{-- Agrega esto en la sección de contenido de tu vista de detalles del cliente --}}

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Agregar Nueva Dirección</h3>
    </div>
    <div class="card-body">

        <div class="card">
            <div class="card-header">
                Información del Cliente
            </div>
            <div class="card-body">
                {{-- Aquí puedes poner más información del cliente si es necesario --}}
                <p>RUT: {{ $cliente->rut }}</p>
                <p>Nombre: {{ $cliente->nombre }}</p>
                <p>Dirección Matriz: {{ $cliente->direccion_matriz }}</p>
                <p>Teléfono: {{ $cliente->fono }}</p>
                {{-- Más campos si necesitas --}}
            </div>
        </div>

        {{-- Tarjeta para mostrar las direcciones --}}
        <div class="card">
            <div class="card-header">
                Direcciones del Cliente
            </div>
            <div class="card-body">
                @if(!$cliente->direcciones->isEmpty())
                    <table class="table" id="tablaDirecciones">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Dirección</th>
                                <th>Ubicación</th>
                                <th>Acciones</th> {{-- Agregar encabezado para la columna de acciones --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cliente->direcciones as $direccion)
                                <tr>
                                    <td>{{ $direccion->tipo }}</td>
                                    <td>{{ $direccion->direccion }}</td>
                                    <td>{{ $direccion->ubicacion->comuna }}, {{ $direccion->ubicacion->region }}</td>
                                    <td>
                                        {{-- Formulario para eliminar dirección --}}
                                        <form action="{{ route('direcciones.destroy', $direccion->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar esta dirección?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div id="messageArea" class="alert alert-success" style="display:none;"></div>
        <form id="addAddressForm" action="{{ route('direcciones.store') }}" method="POST">
            @csrf
            <!-- Asegúrate de incluir cliente_id como un campo oculto en tu formulario -->
            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

            <div class="form-group">
                <label for="tipo">Tipo de Dirección:</label>
                <input type="text" name="tipo" id="tipo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ubicacion_id">Ubicación:</label>
                <select name="ubicacion_id" id="ubicacion_id" class="form-control" required>
                    @foreach ($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}">{{ $ubicacion->comuna }}, {{ $ubicacion->region }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Dirección</button>
        </form>

    </div>
</div>
@stop
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#addAddressForm').on('submit', function(e) {
        e.preventDefault(); // Evita el envío tradicional del formulario

        var formData = new FormData(this); // Prepara los datos del formulario para el envío

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Muestra el área de mensaje con el mensaje de éxito
                $('#messageArea').show().text(response.message);

                // Actualiza la lista de direcciones
                actualizarListaDirecciones(response.direcciones);

                // Limpia el formulario
                $('#addAddressForm')[0].reset();
            },
            error: function(xhr, status, error) {
                // Manejo de error
                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
            }
        });
    });

        function actualizarListaDirecciones(direcciones) {
        var tablaDireccionesHtml = '';
        direcciones.forEach(function(direccion) {
            tablaDireccionesHtml += `
                <tr>
                    <td>${direccion.tipo}</td>
                    <td>${direccion.direccion}</td>
                    <td>${direccion.ubicacion.comuna}, ${direccion.ubicacion.region}</td>
                    <td>
                        <form action="/direcciones/${direccion.id}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            `;
        });
        $('#tablaDirecciones tbody').html(tablaDireccionesHtml);
    }

});
</script>
@endpush
