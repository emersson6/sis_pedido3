@extends('adminlte::page')

@section('title', 'Añadir Cliente')

@section('content_header')
    <h1>Añadir Cliente</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Información del Cliente</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Primera línea -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="rut">RUT:</label>
                        <input type="text" class="form-control" id="rut" name="rut" required>
                    </div>
                    <div class="form-group">
                        <label for="fono">Teléfono:</label>
                        <input type="text" class="form-control" id="fono" name="fono">
                    </div>
                    <div class="form-group">
                        <label for="nombre_contacto">Nombre de Contacto:</label>
                        <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="email_contacto">Email de Contacto:</label>
                        <input type="email" class="form-control" id="email_contacto" name="email_contacto">
                    </div>
                    <div class="form-group">
                        <label for="fono_contacto">Teléfono de Contacto:</label>
                        <input type="text" class="form-control" id="fono_contacto" name="fono_contacto">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="direccion_matriz">Dirección Matriz:</label>
                        <input type="text" class="form-control" id="direccion_matriz" name="direccion_matriz" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_cliente">Tipo de Cliente:</label>
                        <select class="form-control" id="tipo_cliente" name="tipo_cliente">
                            <option value="interno">Interno</option>
                            <option value="externo">Externo</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="canal_venta">Canal de Venta:</label>
                        <select class="form-control" id="canal_venta" name="canal_venta">
                            <option value="Tradicional Santiago">Tradicional Santiago</option>
                            <option value="Venta Directa">Venta Directa</option>
                            <option value="E-Commerce">E-Commerce</option>
                            <option value="Tiendas Especializada">Tiendas Especializada</option>
                            <option value="Venta al detalle">Venta al detalle</option>
                            <option value="Tradicional Regiones">Tradicional Regiones</option>
                            <option value="Supermercados">Supermercados</option>
                            <option value="Foodservice">Foodservice</option>
                            <option value="Distribuidores">Distribuidores</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Segunda línea -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ubicacion_id">Ubicación:</label>
                        <select class="form-control" id="ubicacion_id" name="ubicacion_id">
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}">{{ $ubicacion->region }} - {{ $ubicacion->comuna }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <button type="submit" class="btn btn-success">Agregar Cliente</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
