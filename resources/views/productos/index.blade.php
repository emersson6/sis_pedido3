{{-- Extiende tu layout principal de AdminLTE --}}
@extends('adminlte::page')

{{-- Título de la página --}}
@section('title', 'Lista de Productos')

{{-- Contenido del header de la página --}}
@section('content_header')
    <h1>Lista de Productos</h1>
@stop

{{-- Sección de CSS adicional --}}
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@stop

{{-- Contenido principal de tu página --}}
@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('productos.create') }}" class="btn btn-success">Añadir Nuevo Producto</a>
                <a href="{{ route('productos.import.form') }}" class="btn btn-primary">Importar Productos</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="productosTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Código SKU</th>
                                <th>Nombre</th>
                                <th>Calidad</th>
                                <th>Marca</th>
                                <th>Formato</th>
                                <th>Stock</th>
                                <th>Precio Neto</th>
                                <th>Peso</th>
                                <th>Status</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            <tr>
                                <td>{{ $producto->codigo_sku }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->calidad }}</td>
                                <td>{{ $producto->marca }}</td>
                                <td>{{ $producto->formato }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>${{ number_format($producto->precio_neto, 2) }}</td>
                                <td>{{ $producto->peso }} kg</td>
                                <td>{{ $producto->status }}</td>
                                <td>
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de querer eliminar este producto?')">Eliminar</button>
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

{{-- Sección de JavaScript adicional --}}
@section('js')
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
    $('#productosTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        }
    });
});
</script>
@stop
