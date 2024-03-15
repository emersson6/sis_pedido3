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
                @if($cliente->direcciones->isEmpty())
                    <p>Este cliente no tiene direcciones adicionales.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Dirección</th>
                                <th>Ubicación</th>
                                {{-- Agrega más columnas si necesitas --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cliente->direcciones as $direccion)
                                <tr>
                                    <td>{{ $direccion->tipo }}</td>
                                    <td>{{ $direccion->direccion }}</td>
                                    <td>{{ $direccion->ubicacion->comuna }}, {{ $direccion->ubicacion->region }}</td>
                                    {{-- Más columnas si agregaste más campos en la tabla direcciones --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>




        <form action="{{ route('direcciones.store', $cliente->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="tipo">Tipo de Dirección:</label>
                <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Ejemplo: Oficina, Casa, Sucursal">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingresa la dirección completa">
            </div>
            <div class="form-group">
                <label for="ubicacion_id">Ubicación:</label>
                <select name="ubicacion_id" id="ubicacion_id" class="form-control">
                    {{-- Suponiendo que tienes las ubicaciones pasadas a la vista --}}
                    @foreach($ubicaciones as $ubicacion)
                    <option value="{{ $ubicacion->id }}">{{ $ubicacion->comuna }}, {{ $ubicacion->region }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Agregar Dirección</button>
        </form>
    </div>
</div>

{{-- Aquí continúa el resto de tu vista --}}

@stop
