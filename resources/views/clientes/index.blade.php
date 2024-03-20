{{-- Listado de Clientes --}}
@extends('adminlte::page')

@section('title', 'Lista de Clientes')

@section('content_header')
    <h1>Lista de Clientes</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('clientes.create') }}" class="btn btn-success">Añadir Nuevo Cliente</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="clientesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Dirección Matriz</th>
                                <th>Fono</th>
                                <th>Nombre de Contacto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->rut }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->direccion_matriz }}</td>
                                <td>{{ $cliente->fono }}</td>
                                <td>{{ $cliente->nombre_contacto }}</td>
                                <td>
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-primary btn-sm">Ver Detalles</a>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de querer eliminar este cliente?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

@stop


@section('js')
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#clientesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "ordering": true, // Habilita el ordenamiento de columnas
        "searching": true // Habilita la búsqueda global en la tabla
    });
});
</script>
@stop
