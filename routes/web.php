<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InventoryController;

Route::get('/', [InventoryController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::resource('inventory', InventoryController::class);

Route::post('inventory/pinjam/{id_barang}', [InventoryController::class, 'pinjam'])->name('inventory.pinjam');
Route::post('inventory/tambah-stok/{id_barang}', [InventoryController::class, 'tambahstok'])->name('inventory.tambah-stok');
Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';





