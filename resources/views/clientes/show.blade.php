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
                <table class="table">
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
        <form action="{{ route('direcciones.store') }}" method="POST">
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

{{-- Aquí continúa el resto de tu vista --}}

@stop
