<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Imports\ProductosImport;
use Maatwebsite\Excel\Facades\Excel;


class ProductoController extends Controller
{
    // Muestra la lista de productos
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    // Muestra el formulario para crear un nuevo producto
    public function create()
    {
        return view('productos.create');
    }

    // Guarda un nuevo producto en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'codigo_sku' => 'required|unique:productos,codigo_sku',
            'nombre' => 'required',
            'precio_neto' => 'required|numeric',
            // Agrega otras validaciones según sea necesario
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')
                         ->with('success', 'Producto creado exitosamente.');
    }

    // Muestra el formulario para editar un producto existente
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    // Actualiza un producto en la base de datos
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo_sku' => 'required|unique:productos,codigo_sku,'.$producto->id,
            'nombre' => 'required',
            'precio_neto' => 'required|numeric',
            // Agrega otras validaciones según sea necesario
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
                         ->with('success', 'Producto actualizado exitosamente.');
    }

    // Elimina un producto de la base de datos
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
                         ->with('success', 'Producto eliminado exitosamente.');
    }
    public function showImportForm()
    {
        return view('productos.import');
    }
    public function import(Request $request)
    {
        // Desactivar todos los productos antes de la importación
        Producto::query()->update(['status' => 'inactivo']);

        // Procesar archivo de importación
        Excel::import(new ProductosImport, $request->file('file'));

        // Redirigir a la vista index con un mensaje de éxito
        return redirect()->route('productos.index')
                         ->with('success', 'Productos cargados exitosamente.');
    }
    // Dentro de ProductoController.php
    public function info($productoId)
    {
        $producto = Producto::findOrFail($productoId);
        return response()->json($producto);
    }

    public function buscador(Request $request)
    {
        $term = $request->input('term');
        // Ajusta las consultas según tus modelos y estructura de base de datos.
        $productos = Producto::where('nombre', 'LIKE', '%' . $term . '%')
                        ->orWhereHas('marca', function($query) use ($term) {
                            $query->where('nombre', 'LIKE', '%' . $term . '%');
                        })
                        ->get(['id', 'nombre as text']); // Ajusta los campos según sea necesario

        return response()->json($productos);
    }




}
