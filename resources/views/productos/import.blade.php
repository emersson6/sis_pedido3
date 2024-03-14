@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Importar Productos</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="file" class="form-label">Archivo Excel:</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Importar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
