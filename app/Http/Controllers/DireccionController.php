<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function store(Request $request, $cliente_id)
        {
            $request->validate([
                'tipo' => 'required|max:255',
                'direccion' => 'required|max:255',
                'ubicacion_id' => 'required|integer|exists:ubicaciones,id',
            ]);

            $direccion = new Direccion();
            $direccion->cliente_id = $cliente_id;
            $direccion->tipo = $request->tipo;
            $direccion->direccion = $request->direccion;
            $direccion->ubicacion_id = $request->ubicacion_id;
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
            $cliente_id = $direccion->cliente_id;
            $direccion->delete();

            return redirect()->route('clientes.show', $cliente_id)
                             ->with('success', 'Dirección eliminada con éxito.');
        }

}

