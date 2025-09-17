<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProyectoController;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/login', function () {
    return view('login');
});

// User Management Routes
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    Route::get('/{user}/permissions', [UserController::class, 'permissions'])->name('permissions');
    Route::put('/{user}/permissions', [UserController::class, 'updatePermissions'])->name('update-permissions');
});
// Proyectos Management Routes
Route::prefix('proyectos')->name('proyectos.')->group(function () {
    Route::get('/', [ProyectoController::class, 'index'])->name('index');
    Route::get('/create', [ProyectoController::class, 'create'])->name('create');
    Route::post('/', [ProyectoController::class, 'store'])->name('store');
    Route::get('/{proyecto}', [ProyectoController::class, 'show'])->name('show');
    Route::get('/{proyecto}/edit', [ProyectoController::class, 'edit'])->name('edit');
    Route::put('/{proyecto}', [ProyectoController::class, 'update'])->name('update');
    Route::delete('/{proyecto}', [ProyectoController::class, 'destroy'])->name('destroy');
});

// Opción directa a la vista
use App\Http\Controllers\LocationController;
Route::prefix('locations')->name('locations.')->group(function () {
    Route::get('/', [LocationController::class, 'index'])->name('index'); // Listar
    Route::get('/create', [LocationController::class, 'create'])->name('create'); // Crear
    Route::post('/', [LocationController::class, 'store'])->name('store'); // Guardar
    Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('edit'); // Editar
    Route::put('/{location}', [LocationController::class, 'update'])->name('update'); // Actualizar
    Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy'); // Eliminar
    Route::get('/{location}', [LocationController::class, 'show'])->name('show'); // Mostrar
});

