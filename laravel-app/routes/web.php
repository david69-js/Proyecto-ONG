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
<<<<<<< HEAD
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventIndexController;
use App\Http\Controllers\ProjectIndexController;
=======
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205


Route::get('/', function () {
    return view('index');
});

<<<<<<< HEAD
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

=======
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

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
<<<<<<< HEAD
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
=======
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

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
<<<<<<< HEAD
// Events Management Routes (ADMIN)
// ============================================
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('events', [EventController::class,'index'])->name('events.index');
        Route::get('events/create', [EventController::class,'create'])->name('events.create');
        Route::post('events', [EventController::class,'store'])->name('events.store');

        Route::get('events/{event}', [EventController::class,'show'])->name('events.show');

        Route::get('events/{event}/edit', [EventController::class,'edit'])->name('events.edit');
        Route::put('events/{event}', [EventController::class,'update'])->name('events.update');
        Route::delete('events/{event}', [EventController::class,'destroy'])->name('events.destroy');

        Route::patch('events/{event}/toggle-featured', [EventController::class,'toggleFeatured'])
            ->name('events.toggle_featured');

        Route::post('events/{event}/change-status', [EventController::class,'changeStatus'])
            ->name('events.change-status');

        Route::post('events/{event}/register', [EventController::class,'register'])
            ->name('events.register');

        Route::post('registrations/{registration}/status', [EventController::class,'updateRegistrationStatus'])
            ->name('registrations.update-status');

        Route::delete('registrations/{registration}', [EventController::class,'deleteRegistration'])
            ->name('registrations.destroy');
    });
Route::get('/eventos/{event}', [EventController::class, 'showPublic'])->name('events.public.show');
=======
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
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

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

<<<<<<< HEAD

// About Section Management Routes
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::get('about', [AboutSectionController::class, 'index'])->name('about.index');
        Route::put('about/{id}', [AboutSectionController::class, 'update'])->name('about.update');
    });


// Admin - Hero
Route::middleware(['auth']) 
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('hero', [HeroSectionController::class, 'index'])->name('hero.index');      
        Route::post('hero', [HeroSectionController::class, 'store'])->name('hero.store');      
        Route::put('hero/{id}', [HeroSectionController::class, 'update'])->name('hero.update');
    });



// Event Index Management Routes
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::get('events/index', [EventIndexController::class, 'edit'])->name('events.index.edit');
        Route::patch('events/index/{event}/toggle', [EventIndexController::class, 'toggle'])->name('events.toggle_index');
        Route::patch('events/{event}/unpublish', [EventIndexController::class, 'unpublish'])->name('events.unpublish');
        Route::patch('events/index/{event}/toggle-featured', [EventIndexController::class, 'toggleFeatured'])->name('events.toggle_featured');
    });

// Project Index Management Routes
Route::middleware(['auth'])
    ->prefix('admin/projects')
    ->name('admin.projects.')
    ->group(function() {
        Route::get('/', [ProjectIndexController::class, 'indexAdmin'])->name('index');
        Route::patch('{project}/toggle', [ProjectIndexController::class, 'toggle'])->name('toggle');
        Route::delete('{project}', [ProjectIndexController::class, 'destroy'])->name('destroy');
    });

// Admin - Beneficiaries Management Routes
Route::middleware(['auth'])
    ->prefix('admin/beneficiaries')
    ->name('admin.beneficiaries.')
    ->group(function () {
        Route::get('/', [BeneficiaryController::class, 'index'])->name('index');
        Route::get('/create', [BeneficiaryController::class, 'create'])->name('create');
        Route::post('/', [BeneficiaryController::class, 'store'])->name('store');
        Route::get('/{beneficiary}', [BeneficiaryController::class, 'show'])->name('show');
        Route::get('/{beneficiary}/edit', [BeneficiaryController::class, 'edit'])->name('edit');
        Route::put('/{beneficiary}', [BeneficiaryController::class, 'update'])->name('update');
        Route::delete('/{beneficiary}', [BeneficiaryController::class, 'destroy'])->name('destroy');
    });

// Admin - Sponsors Management Routes
Route::middleware(['auth'])
    ->prefix('admin/sponsors')
    ->name('admin.sponsors.')
    ->group(function () {
        Route::get('/', [SponsorController::class, 'index'])->name('index');
        Route::get('/create', [SponsorController::class, 'create'])->name('create');
        Route::post('/', [SponsorController::class, 'store'])->name('store');
        Route::get('/{sponsor}', [SponsorController::class, 'show'])->name('show');
        Route::get('/{sponsor}/edit', [SponsorController::class, 'edit'])->name('edit');
        Route::put('/{sponsor}', [SponsorController::class, 'update'])->name('update');
        Route::delete('/{sponsor}', [SponsorController::class, 'destroy'])->name('destroy');
        Route::patch('/{sponsor}/toggle-featured', [SponsorController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::patch('/{sponsor}/toggle-status', [SponsorController::class, 'toggleStatus'])->name('toggle-status');
    });

// Admin - Donations Management Routes
Route::middleware(['auth'])
    ->prefix('admin/donations')
    ->name('admin.donations.')
    ->group(function () {
        Route::get('/', [DonationController::class, 'index'])->name('index');
        Route::get('/create', [DonationController::class, 'create'])->name('create');
        Route::post('/', [DonationController::class, 'store'])->name('store');
        Route::get('/{donation}', [DonationController::class, 'show'])->name('show');
        Route::get('/{donation}/edit', [DonationController::class, 'edit'])->name('edit');
        Route::put('/{donation}', [DonationController::class, 'update'])->name('update');
        Route::delete('/{donation}', [DonationController::class, 'destroy'])->name('destroy');
        Route::patch('/{donation}/confirm', [DonationController::class, 'confirm'])->name('confirm');
        Route::patch('/{donation}/process', [DonationController::class, 'process'])->name('process');
        Route::patch('/{donation}/reject', [DonationController::class, 'reject'])->name('reject');
        Route::patch('/{donation}/cancel', [DonationController::class, 'cancel'])->name('cancel');
        Route::get('/reports/statistics', [DonationController::class, 'reports'])->name('reports');
        Route::get('/export/data', [DonationController::class, 'export'])->name('export');
    });
=======
// About Section Management Routes
Route::prefix('admin/about')->name('admin.about.')->group(function () {
    Route::get('/', [AboutSectionController::class, 'index'])->name('index');
    Route::put('/{id}', [AboutSectionController::class, 'update'])->name('update');
});
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
