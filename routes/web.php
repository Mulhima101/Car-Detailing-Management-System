<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Define dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/service/request', [ServiceRequestController::class, 'create'])->name('service.create');
Route::post('/service/request', [ServiceRequestController::class, 'store'])->name('service.store');
Route::get('/service/thankyou/{id}', [ServiceRequestController::class, 'thankYou'])->name('service.thankyou');
Route::get('/service/status/{id}', [ServiceRequestController::class, 'status'])->name('service.status');

// Auth routes
require __DIR__.'/auth.php';

// Admin routes (protected by authentication)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/services', [DashboardController::class, 'allServices'])->name('services');
    Route::get('/completed-services', [DashboardController::class, 'completedServices'])->name('completed-services');
    Route::get('/customers', [DashboardController::class, 'customers'])->name('customers');
    Route::get('/service/{id}', [DashboardController::class, 'viewServiceDetails'])->name('service.details');
    Route::patch('/service/{id}/status', [DashboardController::class, 'updateStatus'])->name('service.update-status');
    Route::get('/settings', function () { return view('admin.settings'); })->name('settings');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});