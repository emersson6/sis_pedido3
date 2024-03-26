<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Direccion;
use Illuminate\Http\Request;
use App\Models\Ubicacion;
use App\Models\Producto;
use App\Models\ItemPedido;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade;
use PDF;



use Illuminate\Support\Facades\DB;


class PedidoController extends Controller
{
    // Muestra el formulario para crear un nuevo pedido
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all(); // Asegúrate de obtener todos los productos aquí
        $ubicaciones = Ubicacion::all();

        // Asegúrate de pasar la variable $productos a la vista
        return view('pedidos.create', compact('clientes', 'productos', 'ubicaciones'));
    }
    // Muestra un pedido específico
    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'direccion', 'items.producto'])->findOrFail($id);
        return view('pedidos.show', compact('pedido'));
    }
    // Almacena un nuevo pedido en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'direccionEnvio' => 'required|exists:direcciones,id',
            'fecha_pedido' => 'required|date',
            'orden_compra' => 'nullable|string',
            'tipo_pedido' => 'required|string',
            'items' => 'required|array',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio_neto' => 'required|numeric',
            'items.*.costo_envio' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $pedido = new Pedido();
            $pedido->cliente_id = $request->cliente_id;
            $pedido->direccion_id = $request->direccionEnvio;
            $pedido->fecha_pedido = $request->fecha_pedido;
            $pedido->orden_compra = $request->orden_compra;
            $pedido->tipo_pedido = $request->tipo_pedido;
            $pedido->comentarios = $request->comentarios ?? '';

            // Calcula el costo de envío total sumando los costos de envío de todos los ítems
            $costoEnvioTotal = array_sum(array_map(function($item) {
                return $item['costo_envio'] * $item['cantidad']; // Asegúrate de multiplicar por la cantidad si es necesario
            }, $request->items));
            $pedido->costo_envio = $costoEnvioTotal;

            $pedido->save();

            foreach ($request->items as $itemData) {

                $producto = Producto::find($itemData['producto_id']);
                if ($producto->stock < $itemData['cantidad']) {
                    // Manejar caso donde no hay suficiente stock
                    throw new \Exception("No hay suficiente stock para el producto con ID: " . $itemData['producto_id']);
                }

                $producto->stock -= $itemData['cantidad'];
                $producto->save();

                $subtotal = $itemData['cantidad'] * $itemData['precio_neto']; // Subtotal por ítem
                $itemPedido = new ItemPedido([
                    'producto_id' => $itemData['producto_id'],
                    'pedido_id' => $pedido->id,
                    'cantidad' => $itemData['cantidad'],
                    'precio_neto' => $itemData['precio_neto'],
                    'subtotal' => $subtotal,
                    // Añade el costo de envío por ítem si es necesario
                ]);
                $itemPedido->save();
            }

            DB::commit();
            return redirect()->route('pedidos.index')->with('success', 'Pedido creado con éxito.');
        } catch (\Exception $e) {
            DB::rollback();
            // Si algo sale mal, se devuelve al usuario a la página anterior con el mensaje de error.
            return back()->withErrors(['error' => 'Hubo un error al crear el pedido: ' . $e->getMessage()]);
        }
    }
    // Lista todos los pedidos
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'direccion'])->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function cambiarEstado(Request $request, $pedidoId)
    {
        $request->validate([
            'status' => 'required|in:pendiente,completado,cancelado', // Asegúrate de validar contra los estados posibles
        ]);

        $pedido = Pedido::findOrFail($pedidoId);
        $pedido->status = $request->status; // Usar 'status' en lugar de 'estado'
        $pedido->save();

        return response()->json(['message' => 'Estado actualizado con éxito']);
    }
    public function descargar(): StreamedResponse
    {
        // Definir los encabezados para el archivo CSV
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=pedidos.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() {
            $file = fopen('php://output', 'w');

            fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

            // Escribir la cabecera del CSV con detalles adicionales
            fputcsv($file, [
                'ID Pedido',
                'Cliente',
                'Dirección',
                'Comuna', // Nueva columna para la comuna
                'Región', // Nueva columna para la región
                'Fecha del Pedido',
                'Orden de Compra',
                'Estado',
                'Costo_envio',
                'Código del Producto',
                'Producto',
                'Cantidad',
                'Precio Neto'
            ]);

            // Obtener todos los pedidos con sus detalles
            $pedidos = Pedido::with(['cliente', 'direccion', 'items.producto'])->get();

            foreach ($pedidos as $pedido) {
                // Para cada pedido, recorrer sus ítems
                foreach ($pedido->items as $item) {
                    $costoEnvioFormat = '$' . number_format($pedido->costo_envio, 0, ',', '.');
                    $precioNetoFormat = '$' . number_format($item->precio_neto, 0, ',', '.');

                    fputcsv($file, [
                        $pedido->id,
                        $pedido->cliente->nombre,
                        $pedido->direccion->direccion,
                        $pedido->direccion->ubicacion->comuna, // Accede a la comuna
                        $pedido->direccion->ubicacion->region, // Accede a la región
                        $pedido->fecha_pedido,
                        $pedido->orden_compra,
                        $pedido->status,
                        $costoEnvioFormat,
                        $item->producto->codigo_sku,
                        $item->producto->nombre,
                        $item->cantidad,
                        $precioNetoFormat,
                    ]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }


    public function descargarPdf($pedidoId)
    {
        $pedido = Pedido::findOrFail($pedidoId);
        $pdf = PDF::loadView('pedidos.pdf', compact('pedido'));

        return $pdf->download('pedido-' . $pedidoId . '.pdf');
    }






    // Añade aquí los demás métodos que necesites, como show, edit, update, destroy
}
