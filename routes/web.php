<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\PedidoController; // Asegúrate de importar el controlador de pedidos aquí
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('productos/import', [ProductoController::class, 'showImportForm'])->name('productos.import.form');
    Route::post('productos/import', [ProductoController::class, 'import'])->name('productos.import');
    Route::resource('productos', ProductoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::get('clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');

    // Rutas para direcciones de clientes
    Route::post('/clientes/{cliente_id}/direcciones', [DireccionController::class, 'store'])->name('direcciones.store');

    Route::get('/direcciones/{id}/edit', [DireccionController::class, 'edit'])->name('direcciones.edit');
    Route::put('/direcciones/{id}', [DireccionController::class, 'update'])->name('direcciones.update');
    Route::delete('/direcciones/{id}', [DireccionController::class, 'destroy'])->name('direcciones.destroy');
    Route::get('/clientes/{cliente_id}/direcciones/create', [DireccionController::class, 'create'])->name('direcciones.create');

    // Rutas para pedidos
    Route::resource('pedidos', PedidoController::class);
    Route::get('/clientes/info/{cliente}', [ClienteController::class, 'info'])->name('clientes.info');
    Route::post('/direcciones/store', [DireccionController::class, 'store']);
    Route::post('/direcciones/ajax/store', [DireccionController::class, 'storeAjax'])->name('direcciones.ajax.store');
    Route::post('/direcciones/store', [DireccionController::class, 'store'])->name('direcciones.store');

    Route::get('/productos/info/{producto}', [ProductoController::class, 'info'])->name('productos.info');
    Route::post('/pedidos/cambiar-estado/{pedido}', [PedidoController::class, 'cambiarEstado'])->name('pedidos.cambiarEstado');


});

require __DIR__.'/auth.php';
