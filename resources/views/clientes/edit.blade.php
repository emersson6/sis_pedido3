@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Actualizar Información del Cliente</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Primera línea -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="rut">RUT:</label>
                        <input type="text" class="form-control" id="rut" name="rut" value="{{ $cliente->rut }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->nombre }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="direccion_matriz">Dirección Matriz:</label>
                        <input type="text" class="form-control" id="direccion_matriz" name="direccion_matriz" value="{{ $cliente->direccion_matriz }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Segunda línea -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fono">Teléfono:</label>
                        <input type="text" class="form-control" id="fono" name="fono" value="{{ $cliente->fono }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombre_contacto">Nombre de Contacto:</label>
                        <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" value="{{ $cliente->nombre_contacto }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fono_contacto">Teléfono de Contacto:</label>
                        <input type="text" class="form-control" id="fono_contacto" name="fono_contacto" value="{{ $cliente->fono_contacto }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Tercera línea -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo_cliente">Tipo de Cliente:</label>
                        <select class="form-control" id="tipo_cliente" name="tipo_cliente">
                            <option value="interno" {{ $cliente->tipo_cliente == 'interno' ? 'selected' : '' }}>Interno</option>
                            <option value="externo" {{ $cliente->tipo_cliente == 'externo' ? 'selected' : '' }}>Externo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="canal_venta">Canal de Venta:</label>
                        <input type="text" class="form-control" id="canal_venta" name="canal_venta" value="{{ $cliente->canal_venta }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ubicacion_id">Ubicación:</label>
                        <select class="form-control" id="ubicacion_id" name="ubicacion_id">
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}" {{ $cliente->ubicacion_id == $ubicacion->id ? 'selected' : '' }}>{{ $ubicacion->region }} - {{ $ubicacion->comuna }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Botón de actualización -->
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
