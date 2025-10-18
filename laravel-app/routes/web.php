<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutSectionController;


Route::get('/', function () {
    return view('index');
});

// Ruta temporal para probar Tabler
Route::get('/dashboard-tabler', function () {
    return view('dashboard-tabler');
})->middleware('auth');

// Ruta de prueba para Tabler
Route::get('/test-tabler', function () {
    return view('test-tabler');
})->middleware('auth');

// Ruta de prueba para Sidebar
Route::get('/test-sidebar', function () {
    return view('test-sidebar');
})->middleware('auth');

// Ruta de prueba para Sidebar Debug
Route::get('/test-sidebar-debug', function () {
    return view('test-sidebar-debug');
})->middleware('auth');


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
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

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
    Route::prefix('events')->name('events.')->middleware('permission:events.view')->group(function () {
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

    // ============================================
    // Donations Management Routes
    // ============================================
    Route::prefix('donations')->name('donations.')->middleware('any.permission:donations.view,donations.view.own')->group(function () {
        Route::get('/', [DonationController::class, 'index'])->name('index');
        Route::get('/create', [DonationController::class, 'create'])->name('create')->middleware('permission:donations.create');
        Route::post('/', [DonationController::class, 'store'])->name('store')->middleware('permission:donations.create');
        Route::get('/{donation}', [DonationController::class, 'show'])->name('show');
        Route::get('/{donation}/edit', [DonationController::class, 'edit'])->name('edit')->middleware('any.permission:donations.edit,donations.view.own');
        Route::put('/{donation}', [DonationController::class, 'update'])->name('update')->middleware('any.permission:donations.edit,donations.view.own');
        Route::delete('/{donation}', [DonationController::class, 'destroy'])->name('destroy')->middleware('any.permission:donations.delete,donations.view.own');
        
        // Acciones específicas de donaciones
        Route::patch('/{donation}/confirm', [DonationController::class, 'confirm'])->name('confirm')->middleware('permission:donations.confirm');
        Route::patch('/{donation}/process', [DonationController::class, 'process'])->name('process')->middleware('permission:donations.process');
        Route::patch('/{donation}/reject', [DonationController::class, 'reject'])->name('reject')->middleware('permission:donations.edit');
        Route::patch('/{donation}/cancel', [DonationController::class, 'cancel'])->name('cancel')->middleware('any.permission:donations.edit,donations.view.own');
        
        // Reportes y exportación
        Route::get('/reports/statistics', [DonationController::class, 'reports'])->name('reports')->middleware('permission:donations.reports');
        Route::get('/export/data', [DonationController::class, 'export'])->name('export')->middleware('permission:donations.export');
    });
});

// Product Management Routes
Route::prefix('products')->name('products.')->middleware('auth')->group(function () {
    // Rutas específicas primero (antes que las genéricas)
    Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware('permission:products.create');
    Route::get('/statistics/overview', [ProductController::class, 'statistics'])->name('statistics')->middleware('permission:products.statistics');
    Route::get('/catalog/show', [ProductController::class, 'catalog'])->name('catalog');
    
    // Rutas administrativas
    Route::middleware('permission:products.view')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
    });
    
    Route::middleware('permission:products.create')->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('store');
    });
    
    Route::middleware('permission:products.edit')->group(function () {
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    });
    
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy')->middleware('permission:products.delete');
    
    // Ruta genérica al final
    Route::get('/{product}', [ProductController::class, 'show'])->name('show')->middleware('permission:products.view');
});

// About Section Management Routes
Route::prefix('admin/about')->name('admin.about.')->group(function () {
    Route::get('/', [AboutSectionController::class, 'index'])->name('index');
    Route::put('/{id}', [AboutSectionController::class, 'update'])->name('update');
});