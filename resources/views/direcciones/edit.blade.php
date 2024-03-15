{{-- Ruta: resources/views/direcciones/edit.blade.php --}}

@extends('adminlte::page')

@section('title', 'Editar Dirección')

@section('content_header')
    <h1>Editar Dirección</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('direcciones.update', $direccion->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="tipo">Tipo de Dirección:</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="{{ $direccion->tipo }}" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $direccion->direccion }}" required>
            </div>
            <div class="form-group">
                <label for="ubicacion_id">Ubicación:</label>
                <select class="form-control" id="ubicacion_id" name="ubicacion_id">
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}" @if($ubicacion->id == $direccion->ubicacion_id) selected @endif>
                            {{ $ubicacion->region }} - {{ $ubicacion->comuna }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Dirección</button>
        </form>
    </div>
</div>
@stop
