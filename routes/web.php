<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\Admin\DashboardController;

// Public routes
Route::get('/', function () {
    return redirect()->route('service.create');
});

Route::get('/service/request', [ServiceRequestController::class, 'create'])->name('service.create');
Route::post('/service/request', [ServiceRequestController::class, 'store'])->name('service.store');
Route::get('/service/thankyou/{id}', [ServiceRequestController::class, 'thankYou'])->name('service.thankyou');

// Admin routes (add middleware for authentication in a real app)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/services', [DashboardController::class, 'allServices'])->name('services');
    Route::patch('/service/{id}/status', [DashboardController::class, 'updateStatus'])->name('service.update-status');
    
    // Placeholder routes for other admin features
    Route::get('/customers', function () { return view('admin.customers'); })->name('customers');
    Route::get('/settings', function () { return view('admin.settings'); })->name('settings');
});