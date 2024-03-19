<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Support\Facades\DB; // Agrega esta línea

class DashboardController extends Controller
{
    public function index()
    {
        $cantidadPedidos = Pedido::count();
        $cantidadClientes = Cliente::count();
        $cantidadProductos = Producto::count();
        $stockTotal = Producto::sum('stock');

        $cantidadPendientes = Pedido::where('status', 'Pendiente')->count();
        $cantidadCompletados = Pedido::where('status', 'Completado')->count();
        $cantidadCancelados = Pedido::where('status', 'Cancelado')->count();

        $estadosPedidos = [
            'Pendiente' => $cantidadPendientes,
            'Completado' => $cantidadCompletados,
            'Cancelado' => $cantidadCancelados,
        ];

        $canalVenta = DB::table('clientes')
            ->select('canal_venta', DB::raw('count(*) as total'))
            ->groupBy('canal_venta')
            ->pluck('total', 'canal_venta')
            ->all();

        return view('dashboard', compact('cantidadPedidos', 'cantidadClientes', 'cantidadProductos', 'stockTotal', 'estadosPedidos', 'canalVenta'));
    }
}
