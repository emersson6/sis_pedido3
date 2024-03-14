<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion; // Añade esta línea
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all(); // Asegúrate de tener el modelo Cliente importado correctamente
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ubicaciones = Ubicacion::all();
        return view('clientes.create', compact('ubicaciones'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|unique:clientes,rut|max:12',
            'nombre' => 'required|max:255',
            'direccion_matriz' => 'required|max:255',
            'ubicacion_id' => 'required|integer|exists:ubicaciones,id',
            'fono' => 'required|max:20',
            'nombre_contacto' => 'nullable|max:255',
            'fono_contacto' => 'nullable|max:20',
            'tipo_cliente' => 'required|in:externo,interno',
            'canal_venta' => 'required|max:255',
            // Agrega más validaciones según sea necesario
        ]);

        DB::beginTransaction();

        try {
            $cliente = new Cliente();
            $cliente->rut = $request->rut;
            $cliente->nombre = $request->nombre;
            $cliente->direccion_matriz = $request->direccion_matriz;
            $cliente->ubicacion_id = $request->ubicacion_id; // Asume que este campo relaciona directamente con la tabla 'ubicaciones'
            $cliente->fono = $request->fono;
            $cliente->nombre_contacto = $request->nombre_contacto;
            $cliente->fono_contacto = $request->fono_contacto;
            $cliente->tipo_cliente = $request->tipo_cliente;
            $cliente->canal_venta = $request->canal_venta;
            $cliente->save();

            DB::commit();
            return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());
            return back()->with('error', 'Hubo un error al crear el cliente');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Busca el cliente por su ID
        $cliente = Cliente::findOrFail($id);

        // Recupera todas las ubicaciones para poder seleccionarlas en el formulario
        $ubicaciones = Ubicacion::all();

        // Retorna la vista de edición con el cliente y las ubicaciones
        return view('clientes.edit', compact('cliente', 'ubicaciones'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rut' => 'required|max:12|unique:clientes,rut,' . $id,
            'nombre' => 'required|max:255',
            'direccion_matriz' => 'required|max:255',
            'ubicacion_id' => 'required|integer|exists:ubicaciones,id',
            'fono' => 'required|max:20',
            'nombre_contacto' => 'nullable|max:255',
            'fono_contacto' => 'nullable|max:20',
            'tipo_cliente' => 'required|in:externo,interno',
            'canal_venta' => 'required|max:255',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->rut = $request->rut;
        $cliente->nombre = $request->nombre;
        $cliente->direccion_matriz = $request->direccion_matriz;
        $cliente->ubicacion_id = $request->ubicacion_id;
        $cliente->fono = $request->fono;
        $cliente->nombre_contacto = $request->nombre_contacto;
        $cliente->fono_contacto = $request->fono_contacto;
        $cliente->tipo_cliente = $request->tipo_cliente;
        $cliente->canal_venta = $request->canal_venta;
        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
