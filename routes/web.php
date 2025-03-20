<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
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
    
    // Settings routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/profile', [SettingsController::class, 'updateProfile'])->name('profile');
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('password');
        Route::post('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications');
        Route::post('/system', [SettingsController::class, 'updateSystem'])->name('system');
        Route::post('/email-templates', [SettingsController::class, 'updateEmailTemplates'])->name('email-templates');
    });
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});