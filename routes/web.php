<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\Compra_detalleController;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\Venta_detalleController;
use App\Http\Controllers\Admin\VentaController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('categoria', CategoriaController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.categoria');
    Route::resource('proveedor', ProveedorController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.proveedor');
    Route::resource('producto', ProductoController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.producto');
    Route::resource('compra', CompraController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.compra');
    Route::resource('compra_detalle', Compra_detalleController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.compra_detalle');
    Route::resource('cliente', ClienteController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.cliente');
    Route::resource('venta', VentaController::class)->only(['index', 'store'])->names('admin.venta');
    Route::resource('venta_detalle', Venta_detalleController::class)->only(['index'])->names('admin.venta_detalle');
    // Ruta para consultar DNI
    Route::get('cliente/consultar-dni', [ClienteController::class, 'consultarDni'])->name('admin.cliente.consultar-dni');
    // Ruta para consultar RUC
    Route::get('/proveedor/consultar-ruc', [ProveedorController::class, 'consultarRuc'])->name('admin.proveedor.consultar-ruc');
    // Ruta para consultar producto por código
    Route::post('/venta/get-product', [VentaController::class, 'getProduct'])->name('admin.venta.get-product');
    // Ruta para consultar cliente por DNI
    Route::post('/venta/get-customer', [VentaController::class, 'getCustomer'])->name('admin.venta.get-customer');
    // Rutas para notificaciones
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');
});

require __DIR__.'/auth.php';
