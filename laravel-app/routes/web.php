<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BeneficiaryController;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// User Management Routes
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index')->middleware('permission:users.view');
    Route::get('/create', [UserController::class, 'create'])->name('create')->middleware('permission:users.create');
    Route::post('/', [UserController::class, 'store'])->name('store')->middleware('permission:users.create');
    Route::get('/{user}', [UserController::class, 'show'])->name('show')->middleware('permission:users.view');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit')->middleware('permission:users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update')->middleware('permission:users.edit');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->middleware('permission:users.delete');
    Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:users.edit');
    Route::get('/{user}/permissions', [UserController::class, 'permissions'])->name('permissions')->middleware('permission:roles.assign');
    Route::put('/{user}/permissions', [UserController::class, 'updatePermissions'])->name('update-permissions')->middleware('permission:roles.assign');
});
// Proyectos Management Routes
Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index')->middleware('permission:projects.view');
    Route::get('/create', [ProjectController::class, 'create'])->name('create')->middleware('permission:projects.create');
    Route::post('/', [ProjectController::class, 'store'])->name('store')->middleware('permission:projects.create');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show')->middleware('permission:projects.view');
    Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit')->middleware('permission:projects.edit');
    Route::put('/{project}', [ProjectController::class, 'update'])->name('update')->middleware('permission:projects.edit');
    Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy')->middleware('permission:projects.delete');
});

// Locations Management Routes
Route::prefix('locations')->name('locations.')->group(function () {
    Route::get('/', [LocationController::class, 'index'])->name('index')->middleware('permission:locations.view');
    Route::get('/create', [LocationController::class, 'create'])->name('create')->middleware('permission:locations.create');
    Route::post('/', [LocationController::class, 'store'])->name('store')->middleware('permission:locations.create');
    Route::get('/{location}', [LocationController::class, 'show'])->name('show')->middleware('permission:locations.view');
    Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('edit')->middleware('permission:locations.edit');
    Route::put('/{location}', [LocationController::class, 'update'])->name('update')->middleware('permission:locations.edit');
    Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy')->middleware('permission:locations.delete');
});

// Beneficiaries Management Routes
Route::prefix('beneficiaries')->name('beneficiaries.')->group(function () {
    Route::get('/', [BeneficiaryController::class, 'index'])->name('index')->middleware('permission:beneficiaries.view');
    Route::get('/create', [BeneficiaryController::class, 'create'])->name('create')->middleware('permission:beneficiaries.create');
    Route::post('/', [BeneficiaryController::class, 'store'])->name('store')->middleware('permission:beneficiaries.create');
    Route::get('/{beneficiary}', [BeneficiaryController::class, 'show'])->name('show')->middleware('permission:beneficiaries.view');
    Route::get('/{beneficiary}/edit', [BeneficiaryController::class, 'edit'])->name('edit')->middleware('permission:beneficiaries.edit');
    Route::put('/{beneficiary}', [BeneficiaryController::class, 'update'])->name('update')->middleware('permission:beneficiaries.edit');
    Route::delete('/{beneficiary}', [BeneficiaryController::class, 'destroy'])->name('destroy')->middleware('permission:beneficiaries.delete');
});
