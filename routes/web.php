<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas accesibles para cualquier usuario autenticado (básico o administrador)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas exclusivas para ADMINISTRADORES
Route::middleware(['auth', 'verified', 'is.admin'])->prefix('admin')->group(function () {
    Route::get('/users', [DashboardController::class, 'listUsers'])->name('admin.users.index');
    Route::get('/users/create', [DashboardController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [DashboardController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/audit', [DashboardController::class, 'showAuditLog'])->name('admin.audit');

    Route::get('/users/{user}/edit', [DashboardController::class, 'editUser'])->name('admin.users.edit');
    Route::patch('/users/{user}', [DashboardController::class, 'updateUser'])->name('admin.users.update');

    Route::delete('/users/{user}', [DashboardController::class, 'destroyUser'])->name('admin.users.destroy');

    // Ruta para actualizar el rol de un usuario
    Route::patch('/users/{user}/update-role', [DashboardController::class, 'updateUserRole'])->name('admin.users.update-role');
});

// Esta línea es la que importa las rutas de autenticación
require __DIR__.'/auth.php';