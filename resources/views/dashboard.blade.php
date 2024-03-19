@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        @php
            $infoBoxes = [
                ['icon' => 'far fa-clipboard', 'bg' => 'bg-success', 'text' => 'Pedidos', 'number' => $cantidadPedidos],
                ['icon' => 'far fa-user', 'bg' => 'bg-info', 'text' => 'Clientes', 'number' => $cantidadClientes],
                ['icon' => 'far fa-star', 'bg' => 'bg-warning', 'text' => 'Productos', 'number' => $cantidadProductos],
                ['icon' => 'fas fa-boxes', 'bg' => 'bg-danger', 'text' => 'Stock Total', 'number' => $stockTotal]
            ];
        @endphp

        @foreach($infoBoxes as $box)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon {{ $box['bg'] }}"><i class="{{ $box['icon'] }}"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ $box['text'] }}</span>
                        <span class="info-box-number">{{ $box['number'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Estado de los Pedidos
                </div>
                <div class="card-body">
                    <canvas id="chartStatusPedidos"></canvas>
                </div>
            </div>
        </div>

        <!-- Nueva columna para el gráfico de tipo de clientes -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Canal de Venta
                </div>
                <div class="card-body">
                    <canvas id="chartCanalVenta"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctxStatusPedidos = document.getElementById('chartStatusPedidos').getContext('2d');
        var chartStatusPedidos = new Chart(ctxStatusPedidos, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($estadosPedidos)) !!},
                datasets: [{
                    label: 'Estado de Pedidos',
                    data: {!! json_encode(array_values($estadosPedidos)) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        // Añade más colores si necesitas
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        // Más bordes de colores
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        var ctxCanalVenta = document.getElementById('chartCanalVenta').getContext('2d');
        var chartCanalVenta = new Chart(ctxCanalVenta, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($canalVenta)) !!},
                datasets: [{
                    label: 'Canal de Venta',
                    data: {!! json_encode(array_values($canalVenta)) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Rojo
                        'rgba(54, 162, 235, 0.2)', // Azul
                        'rgba(255, 206, 86, 0.2)', // Amarillo
                        // Agrega más colores si tienes más canales de venta
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        // Más bordes de colores
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    });
</script>
@stop
