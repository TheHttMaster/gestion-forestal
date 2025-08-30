<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\AreaController;
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

   // RUTAS DE PROVEEDORES 
    Route::resource('providers', ProviderController::class)->names([
        'index' => 'providers.index',
        'create' => 'providers.create', 
        'edit' => 'providers.edit',
        'update' => 'providers.update',
    ]);

    // Rutas adicionales para funcionalidades extra de proveedores
    Route::prefix('providers')->group(function () {
        Route::post('{provider}/toggle-status', [ProviderController::class, 'toggleStatus'])
            ->name('providers.toggle-status');
        Route::post('{provider}/restore', [ProviderController::class, 'restore'])
            ->name('providers.restore');
        Route::delete('{provider}/force-delete', [ProviderController::class, 'forceDelete'])
            ->name('providers.force-delete');
    });


    // Rutas para gestión de áreas
    Route::resource('areas', AreaController::class)->except(['show']);

    // Rutas adicionales
    Route::prefix('areas')->group(function () {
        Route::get('/{area}/toggle-status', [AreaController::class, 'toggleStatus'])
            ->name('areas.toggle-status');
        
        Route::get('/search/{search}', [AreaController::class, 'search'])
            ->name('areas.search');
        
        Route::get('/{area}', [AreaController::class, 'show'])
            ->name('areas.show');
    });
});
// Rutas exclusivas para ADMINISTRADORES
// Rutas del panel de administración (solo para administradores)
Route::middleware(['auth', 'verified', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    // Usuarios: Rutas de recurso y adicionales
    Route::resource('users', UserController::class)->except(['show'])->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    // 🔥 MOVER AQUÍ las rutas personalizadas de usuarios
    Route::get('users/disabled', [UserController::class, 'listDisabledUsers'])->name('users.disabled');
    Route::patch('users/{user}/update-role', [UserController::class, 'updateUserRole'])->name('users.update-role');
    Route::post('users/{user}/enable', [UserController::class, 'enableUser'])->name('users.enable');
    
    // 🔥 MOVER también la ruta de auditoría aquí
    Route::get('/audit', [AuditLogController::class, 'showAuditLog'])->name('audit');
});


Route::get('/audit', [AuditLogController::class, 'showAuditLog'])->name('admin.audit');
// Esta línea es la que importa las rutas de autenticación
require __DIR__.'/auth.php';