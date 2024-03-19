<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function store(Request $request)
    {
        $cliente_id = $request->cliente_id; // Ahora obtenemos cliente_id directamente del Request

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id', // Asegúrate de validar cliente_id también
            'tipo' => 'required|max:255',
            'direccion' => 'required|max:255',
            'ubicacion_id' => 'required|integer|exists:ubicaciones,id',
        ]);

        $direccion = new Direccion([
            'cliente_id' => $cliente_id,
            'tipo' => $request->tipo,
            'direccion' => $request->direccion,
            'ubicacion_id' => $request->ubicacion_id,
        ]);
        $direccion->save();

        return redirect()->route('clientes.show', $cliente_id)->with('success', 'Dirección agregada con éxito.');
    }
        public function edit($id)
        {
            $direccion = Direccion::findOrFail($id);
            $ubicaciones = Ubicacion::all();
            return view('direcciones.edit', compact('direccion', 'ubicaciones'));
        }

        public function update(Request $request, $id)
        {
            $request->validate([
                'tipo' => 'required|max:255',
                'direccion' => 'required|max:255',
                'ubicacion_id' => 'required|integer|exists:ubicaciones,id',
            ]);

            $direccion = Direccion::findOrFail($id);
            $direccion->update([
                'tipo' => $request->tipo,
                'direccion' => $request->direccion,
                'ubicacion_id' => $request->ubicacion_id,
            ]);

            return redirect()->route('clientes.show', $direccion->cliente_id)
                             ->with('success', 'Dirección actualizada con éxito.');
        }

        public function destroy($id)
        {
            $direccion = Direccion::findOrFail($id);
            $clienteId = $direccion->cliente_id;
            $direccion->delete();

            return redirect()->route('clientes.show', $clienteId)->with('success', 'Dirección eliminada con éxito.');
        }


        public function storeAjax(Request $request)
        {
            $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'tipo' => 'required|max:255',
                'direccion' => 'required|max:255',
                'ubicacion_id' => 'required|integer|exists:ubicaciones,id',
            ]);

            $direccion = new Direccion();
            $direccion->cliente_id = $request->cliente_id;
            $direccion->tipo = $request->tipo;
            $direccion->direccion = $request->direccion;
            $direccion->ubicacion_id = $request->ubicacion_id;
            $direccion->save();

            // Podrías devolver los detalles de la nueva dirección o simplemente un mensaje de éxito.
            return response()->json([
                'success' => true,
                'message' => 'Dirección agregada con éxito.',
                'direccion' => $direccion
            ]);
        }



}

