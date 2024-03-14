@extends('adminlte::page')

@section('title', 'Añadir Nuevo Producto')

@section('content_header')
    <h1>Añadir Nuevo Producto</h1>
@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card" style="width: 70%;">
        <div class="card-body">
            <form action="{{ route('productos.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="codigo_sku" class="form-label">Código SKU</label>
                    <input type="text" class="form-control" id="codigo_sku" name="codigo_sku" placeholder="Código SKU" required>
                </div>
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="col-md-4">
                    <label for="calidad" class="form-label">Calidad</label>
                    <input type="text" class="form-control" id="calidad" name="calidad" placeholder="Calidad">
                </div>
                <div class="col-md-4">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca">
                </div>
                <div class="col-md-4">
                    <label for="formato" class="form-label">Formato</label>
                    <input type="text" class="form-control" id="formato" name="formato" placeholder="Formato">
                </div>
                <div class="col-md-4">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" required>
                </div>
                <div class="col-md-3">
                    <label for="precio_neto" class="form-label">Precio Neto</label>
                    <input type="text" class="form-control" id="precio_neto" name="precio_neto" placeholder="Precio Neto" required>
                </div>
                <div class="col-md-3">
                    <label for="peso" class="form-label">Peso</label>
                    <input type="text" class="form-control" id="peso" name="peso" placeholder="Peso">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="custom-select">
                        <option value="" disabled selected>Elige...</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
