<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader; // Asegúrate de incluir la biblioteca league/csv con Composer

class UbicacionesTableSeeder extends Seeder
{
    public function run()
    {
        // Asegúrate de que el archivo CSV esté en la carpeta database/seeds
        $csv = Reader::createFromPath(database_path('seeds/ubicaciones.csv'), 'r');
        $csv->setDelimiter(';'); // Establecer el delimitador correcto si no es una coma
        $csv->setHeaderOffset(0);

        // Lee cada registro del CSV
        // ...
        foreach ($csv as $record) {
            if (isset($record['region']) && isset($record['comuna'])) {
                DB::table('ubicaciones')->insert([
                    'region' => $record['region'],
                    'comuna' => $record['comuna'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                // Añade un log de depuración
                \Log::info("Insertando: ", $record);
            } else {
                // Añade un log de depuración
                \Log::warning("Registro no insertado: ", $record);
            }
        }
        // ...

    }
}
