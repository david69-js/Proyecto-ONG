<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/ingresar', function () {
    return view('ingresar');
});

Route::resource('beneficiarios', BeneficiarioController::class);

use App\Http\Controllers\UsuarioController;

// Rutas personalizadas en español
Route::get('usuario', [UsuarioController::class, 'index'])->name('usuario.index');
Route::get('usuario/crear', [UsuarioController::class, 'crear'])->name('usuario.crear');
