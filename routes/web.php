<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverShipmentController;

Route::get('/', function () {
    return view('auth.login');
});

// Redirect user sesuai role setelah login
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('driver.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');
});

// hanya admin bisa buat surat jalan
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/shipments/create', [ShipmentController::class, 'create'])->name('shipments.create');
    Route::get('/shipments/index', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::post('/shipments', [ShipmentController::class, 'store'])->name('shipments.store');
});

//Akses download surat jalan untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('shipments', ShipmentController::class);
    Route::get('/shipments/{shipment}/pdf', [ShipmentController::class, 'downloadPdf'])->name('shipments.pdf');
});

//Akses admin membuat akun driver
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/drivers/create', [DriverController::class, 'create'])->name('drivers.create');
    Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::delete('/drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');
});

// Dashboard Driver
Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('/driver/dashboard', function () {
        return view('dashboard.driver');
    })->name('driver.dashboard');

    Route::get('/driver/shipments', [DriverShipmentController::class, 'driverIndex'])->name('driver.shipments.index');
    Route::get('/driver/shipments/{shipment}', [DriverShipmentController::class, 'driverShow'])->name('driver.shipments.show');
    Route::get('/driver/shipments/{shipment}/pdf', [DriverShipmentController::class, 'driverDownloadPdf'])->name('driver.shipments.pdf');
});

require __DIR__.'/auth.php';
