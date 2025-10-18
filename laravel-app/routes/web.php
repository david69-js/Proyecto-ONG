<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AboutSectionController;


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

// ============================================
// RUTAS PROTEGIDAS - Requieren autenticación
// ============================================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ============================================
    // User Management Routes
    // ============================================
    Route::prefix('users')->name('users.')->middleware('any.permission:users.view,profile.view.own')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')->middleware('permission:users.view');
        Route::get('/create', [UserController::class, 'create'])->name('create')->middleware('permission:users.create');
        Route::post('/', [UserController::class, 'store'])->name('store')->middleware('permission:users.create');
        Route::get('/{user}', [UserController::class, 'show'])->name('show')->middleware('any.permission:users.view,profile.view.own');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit')->middleware('any.permission:users.edit,profile.edit.own');
        Route::put('/{user}', [UserController::class, 'update'])->name('update')->middleware('any.permission:users.edit,profile.edit.own');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->middleware('permission:users.delete');
        Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:users.edit');
        Route::get('/{user}/permissions', [UserController::class, 'permissions'])->name('permissions')->middleware('permission:roles.assign');
        Route::put('/{user}/permissions', [UserController::class, 'updatePermissions'])->name('update-permissions')->middleware('permission:roles.assign');
    });

    // ============================================
    // Proyectos Management Routes
    // ============================================
    Route::prefix('projects')->name('projects.')->middleware('any.permission:projects.view,projects.view.own')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create')->middleware('permission:projects.create');
        Route::post('/', [ProjectController::class, 'store'])->name('store')->middleware('permission:projects.create');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit')->middleware('permission:projects.edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update')->middleware('permission:projects.edit');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy')->middleware('permission:projects.delete');
    });

    // ============================================
    // Locations Management Routes
    // ============================================
    Route::prefix('locations')->name('locations.')->middleware('permission:locations.view')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create')->middleware('permission:locations.create');
        Route::post('/', [LocationController::class, 'store'])->name('store')->middleware('permission:locations.create');
        Route::get('/{location}', [LocationController::class, 'show'])->name('show');
        Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('edit')->middleware('permission:locations.edit');
        Route::put('/{location}', [LocationController::class, 'update'])->name('update')->middleware('permission:locations.edit');
        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy')->middleware('permission:locations.delete');
    });

    // ============================================
    // Beneficiaries Management Routes
    // ============================================
    Route::prefix('beneficiaries')->name('beneficiaries.')->middleware('any.permission:beneficiaries.view,benefits.view.own')->group(function () {
        Route::get('/', [BeneficiaryController::class, 'index'])->name('index');
        Route::get('/create', [BeneficiaryController::class, 'create'])->name('create')->middleware('permission:beneficiaries.create');
        Route::post('/', [BeneficiaryController::class, 'store'])->name('store')->middleware('permission:beneficiaries.create');
        Route::get('/{beneficiary}', [BeneficiaryController::class, 'show'])->name('show');
        Route::get('/{beneficiary}/edit', [BeneficiaryController::class, 'edit'])->name('edit')->middleware('any.permission:beneficiaries.edit,profile.edit.own');
        Route::put('/{beneficiary}', [BeneficiaryController::class, 'update'])->name('update')->middleware('any.permission:beneficiaries.edit,profile.edit.own');
        Route::delete('/{beneficiary}', [BeneficiaryController::class, 'destroy'])->name('destroy')->middleware('permission:beneficiaries.delete');
    });

    // ============================================
    // Sponsors Management Routes
    // ============================================
    Route::prefix('sponsors')->name('sponsors.')->middleware('permission:sponsors.view')->group(function () {
        Route::get('/', [SponsorController::class, 'index'])->name('index');
        Route::get('/create', [SponsorController::class, 'create'])->name('create')->middleware('permission:sponsors.create');
        Route::post('/', [SponsorController::class, 'store'])->name('store')->middleware('permission:sponsors.create');
        Route::get('/{sponsor}', [SponsorController::class, 'show'])->name('show');
        Route::get('/{sponsor}/edit', [SponsorController::class, 'edit'])->name('edit')->middleware('permission:sponsors.edit');
        Route::put('/{sponsor}', [SponsorController::class, 'update'])->name('update')->middleware('permission:sponsors.edit');
        Route::delete('/{sponsor}', [SponsorController::class, 'destroy'])->name('destroy')->middleware('permission:sponsors.delete');
        Route::patch('/{sponsor}/toggle-featured', [SponsorController::class, 'toggleFeatured'])->name('toggle-featured')->middleware('permission:sponsors.edit');
        Route::patch('/{sponsor}/toggle-status', [SponsorController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:sponsors.edit');
    });

  // ============================================
    // Events Management Routes
    // ============================================
    Route::prefix('events')->name('events.')->middleware('any.permission:events.view')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create')->middleware('permission:events.create');
        Route::post('/', [EventController::class, 'store'])->name('store')->middleware('permission:events.create');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit')->middleware('permission:events.edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update')->middleware('permission:events.edit');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy')->middleware('permission:events.delete');
        Route::patch('/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])->name('toggle-featured')->middleware('permission:events.edit');
        Route::patch('/{event}/change-status', [EventController::class, 'changeStatus'])->name('change-status')->middleware('permission:events.edit');
        Route::post('/{event}/register', [EventController::class, 'register'])->name('register');
        Route::patch('/registrations/{registration}/status', [EventController::class, 'updateRegistrationStatus'])->name('registration.status')->middleware('permission:events.edit');
        Route::delete('/registrations/{registration}', [EventController::class, 'deleteRegistration'])->name('registration.delete')->middleware('permission:events.edit');
    });
});


// About Section Management Routes
Route::prefix('admin/about')->name('admin.about.')->middleware('auth')->group(function () {
    Route::get('/', [AboutSectionController::class, 'index'])->name('index');
    Route::put('/{id}', [AboutSectionController::class, 'update'])->name('update');
});