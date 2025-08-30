<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuditLogController;

// Rutas públicas
Route::get('/', function () {
    return view('auth.login');
});

// Rutas accesibles para cualquier usuario autenticado (básico o administrador)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTAS DE PROVEEDORES - PARA USUARIOS AUTENTICADOS
    Route::resource('providers', ProviderController::class);

    // Rutas adicionales para funcionalidades extra de proveedores
    Route::prefix('providers')->group(function () {
        Route::post('{provider}/toggle-status', [ProviderController::class, 'toggleStatus'])
            ->name('providers.toggle-status');
        Route::post('{id}/restore', [ProviderController::class, 'restore'])
            ->name('providers.restore');
        Route::delete('{id}/force-delete', [ProviderController::class, 'forceDelete'])
            ->name('providers.force-delete');
    });
});

// Rutas exclusivas para ADMINISTRADORES
// Rutas del panel de administración (solo para administradores)
Route::middleware(['auth', 'verified', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    // Usuarios: Rutas de recurso y adicionales
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
});

// Rutas personalizadas para el controlador de usuarios
Route::controller(UserController::class)->group(function () {
    Route::get('users/disabled', 'listDisabledUsers')->name('admin.users.disabled');
    Route::patch('users/{user}/update-role', 'updateUserRole')->name('admin.users.update-role');
    Route::post('users/{user}/enable', 'enableUser')->name('admin.users.enable');
});

Route::get('/audit', [AuditLogController::class, 'showAuditLog'])->name('admin.audit');
// Esta línea es la que importa las rutas de autenticación
require __DIR__.'/auth.php';