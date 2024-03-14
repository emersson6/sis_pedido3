<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Producto;

class ProductosImport implements ToModel, WithUpserts, WithHeadingRow
{
    // ...

    public function model(array $row)
    {
        // Encuentra el producto por su código SKU, o crea uno nuevo
        $producto = Producto::updateOrCreate(
            ['codigo_sku' => $row['codigo_sku']],
            [
                'nombre' => $row['nombre'],
                'calidad' => $row['calidad'],
                'marca' => $row['marca'],
                'formato' => $row['formato'],
                'stock' => $row['stock'],
                'precio_neto' => $row['precio_neto'],
                'peso' => $row['peso'],
                'status' => 'activo' // Asumiendo que si se importa o actualiza debe estar activo
            ]
        );

        return $producto;
    }

    public function uniqueBy()
    {
        return 'codigo_sku';
    }

    // ...
}
