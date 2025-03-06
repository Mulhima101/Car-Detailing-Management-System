<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarServiceController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/service-request', [CarServiceController::class, 'create'])->name('service.form');
Route::post('/service-request', [CarServiceController::class, 'store'])->name('service.store');

// Admin routes with auth middleware
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/in-progress', [CarServiceController::class, 'index'])->name('admin.in-progress');
    Route::patch('/service/{carService}', [CarServiceController::class, 'update'])->name('service.update');
    
    Route::get('/all-services', [CarServiceController::class, 'allServices'])->name('admin.all-services');
    Route::get('/completed-services', [CarServiceController::class, 'completedServices'])->name('admin.completed-services');
    Route::get('/customers', [CarServiceController::class, 'customers'])->name('admin.customers');
});

// Authentication routes
require __DIR__.'/auth.php';