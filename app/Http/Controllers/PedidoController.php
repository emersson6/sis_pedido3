<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Direccion;
use Illuminate\Http\Request;
use App\Models\Ubicacion;
use App\Models\Producto;
use App\Models\ItemPedido;

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
        /*dd($request->all());*/
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
            // Continúa validando otros campos necesarios aquí
        ]);

        DB::beginTransaction();
        try {
            $pedido = new Pedido();
            $pedido->cliente_id = $request->cliente_id;
            $pedido->direccion_id = $request->direccionEnvio; // Cambiado de 'direccion_id' a 'direccionEnvio', según tu input
            $pedido->costo_envio = $request->costo_envio;
            $pedido->comentarios = $request->comentarios ?? '';
            $pedido->fecha_pedido = $request->fecha_pedido;
            $pedido->orden_compra = $request->orden_compra ?? '';
            $pedido->tipo_pedido = $request->tipo_pedido;

            // Agrega cualquier otro campo necesario que falte aquí
            $pedido->save();

            foreach ($request->items as $itemData) {
                $subtotal = $itemData['cantidad'] * $itemData['precio_neto']; // Calcula el subtotal aquí
                $itemPedido = new ItemPedido([
                    'producto_id' => $itemData['producto_id'],
                    'pedido_id' => $pedido->id, // Asegúrate de asignar el ID del pedido que acabas de crear
                    'cantidad' => $itemData['cantidad'],
                    'precio_neto' => $itemData['precio_neto'],
                    'subtotal' => $subtotal,
                    // Agrega otros campos si son necesarios
                ]);
                // Asegúrate de que 'ItemPedido' es el nombre correcto del modelo que corresponde a la tabla 'item_pedidos'
                $itemPedido->save(); // Guarda cada ítem individualmente
            }

            DB::commit();
            return redirect()->route('pedidos.index')->with('success', 'Pedido creado con éxito.');
        } catch (\Exception $e) {
            DB::rollback();
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
        $pedido = Pedido::find($pedidoId);
        if ($pedido) {
            $pedido->estado = $request->estado;
            $pedido->save();
            return response()->json(['success' => 'Estado actualizado correctamente.']);
        }

        return response()->json(['error' => 'Pedido no encontrado.'], 404);
    }


    // Añade aquí los demás métodos que necesites, como show, edit, update, destroy
}
