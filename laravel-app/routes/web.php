<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutSectionController;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\EventIndexController;
use App\Http\Controllers\ProjectIndexController;
use App\Http\Controllers\BeneficiaryTestimonialController;
use App\Http\Controllers\SponsorHighlightController;
use App\Http\Controllers\DonorHighlightController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', fn() => view('about'));

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

/* Público: detalle de evento */
Route::get('/eventos/{event}', [EventController::class, 'showPublic'])->name('events.public.show');

/*
|--------------------------------------------------------------------------
| Rutas de prueba (solo autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard-tabler', fn() => view('dashboard-tabler'));
    Route::get('/test-tabler', fn() => view('test-tabler'));
    Route::get('/test-sidebar', fn() => view('test-sidebar'));
    Route::get('/test-sidebar-debug', fn() => view('test-sidebar-debug'));
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas principales (sin prefijo /admin en la URL)
|--------------------------------------------------------------------------
| Aquí se mantienen los permisos existentes. Si quieres también quitarlos,
| avísame y te lo entrego sin permisos en todo el sitio.
*/
Route::middleware(['auth'])->group(function () {

    // Users
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
        Route::delete('/{user}/avatar', [UserController::class, 'deleteAvatar'])->name('avatar.delete')->middleware('any.permission:users.edit,profile.edit.own');
    });

    // Projects
    Route::prefix('projects')->name('projects.')->middleware('any.permission:projects.view,projects.view.own')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create')->middleware('permission:projects.create');
        Route::post('/', [ProjectController::class, 'store'])->name('store')->middleware('permission:projects.create');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit')->middleware('permission:projects.edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update')->middleware('permission:projects.edit');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy')->middleware('permission:projects.delete');
        Route::delete('/phase-images/{image}', [ProjectController::class, 'deletePhaseImage'])->name('phase-images.destroy')->middleware('permission:projects.edit');
    });

    // Locations
    Route::prefix('locations')->name('locations.')->middleware('permission:locations.view')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create')->middleware('permission:locations.create');
        Route::post('/', [LocationController::class, 'store'])->name('store')->middleware('permission:locations.create');
        Route::get('/{location}', [LocationController::class, 'show'])->name('show');
        Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('edit')->middleware('permission:locations.edit');
        Route::put('/{location}', [LocationController::class, 'update'])->name('update')->middleware('permission:locations.edit');
        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy')->middleware('permission:locations.delete');
    });

    // Beneficiaries
    Route::prefix('beneficiaries')->name('beneficiaries.')->middleware('any.permission:beneficiaries.view,benefits.view.own')->group(function () {
        Route::get('/', [BeneficiaryController::class, 'index'])->name('index');
        Route::get('/create', [BeneficiaryController::class, 'create'])->name('create')->middleware('permission:beneficiaries.create');
        Route::post('/', [BeneficiaryController::class, 'store'])->name('store')->middleware('permission:beneficiaries.create');
        Route::get('/{beneficiary}', [BeneficiaryController::class, 'show'])->name('show');
        Route::get('/{beneficiary}/edit', [BeneficiaryController::class, 'edit'])->name('edit')->middleware('any.permission:beneficiaries.edit,profile.edit.own');
        Route::put('/{beneficiary}', [BeneficiaryController::class, 'update'])->name('update')->middleware('any.permission:beneficiaries.edit,profile.edit.own');
        Route::delete('/{beneficiary}', [BeneficiaryController::class, 'destroy'])->name('destroy')->middleware('permission:beneficiaries.delete');
    });

    // Sponsors
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

    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware('permission:products.create');
        Route::get('/statistics/overview', [ProductController::class, 'statistics'])->name('statistics')->middleware('permission:products.statistics');
        Route::get('/catalog/show', [ProductController::class, 'catalog'])->name('catalog');

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
        Route::get('/{product}', [ProductController::class, 'show'])->name('show')->middleware('permission:products.view');
    });

});

/*
|--------------------------------------------------------------------------
| ADMIN (/admin) — nombres admin.*
|--------------------------------------------------------------------------
| Aquí se desactivan TODOS los chequeos de permisos (permission/any.permission)
| para evitar 403. Solo exige estar autenticado.
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->withoutMiddleware(['permission','any.permission'])
    ->group(function () {

        // ====== Events ======
        Route::resource('events', EventController::class)->names('events');

        // ====== Events Admin (vistas específicas) ======
        Route::prefix('events-admin')->name('events-admin.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/create', [EventController::class, 'create'])->name('create');
            Route::post('/', [EventController::class, 'store'])->name('store');
            Route::get('/{event}', [EventController::class, 'show'])->name('show');
            Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
            Route::put('/{event}', [EventController::class, 'update'])->name('update');
            Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
            Route::get('/reports', [EventController::class, 'reports'])->name('reports');
        });

        // Extras de Events
        Route::get('events/reports', [EventController::class, 'reports'])->name('events.reports');
        Route::get('events/{event}/registrations', [EventController::class, 'registrations'])->name('events.registrations');
        Route::patch('events/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])->name('events.toggle_featured');
        Route::post('events/{event}/change-status', [EventController::class, 'changeStatus'])->name('events.change-status');
        Route::post('events/{event}/register', [EventController::class, 'register'])->name('events.register');
        Route::post('registrations/{registration}/status', [EventController::class, 'updateRegistrationStatus'])->name('registrations.update-status');
        Route::delete('registrations/{registration}', [EventController::class, 'deleteRegistration'])->name('registrations.destroy');
        Route::post('events/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])
            ->name('events.toggle-featured'); 

        // ====== Donations ======
        Route::resource('donations', DonationController::class)->names('donations');
        Route::get('donations/reports', [DonationController::class, 'reports'])->name('donations.reports');
        Route::get('donations/export', [DonationController::class, 'export'])->name('donations.export');

        // ====== Donations Admin (vistas específicas) ======
        Route::prefix('donations-admin')->name('donations-admin.')->group(function () {
            Route::get('/', [DonationController::class, 'index'])->name('index');
            Route::get('/create', [DonationController::class, 'create'])->name('create');
            Route::post('/', [DonationController::class, 'store'])->name('store');
            Route::get('/reports', [DonationController::class, 'reports'])->name('reports');
            Route::get('/export', [DonationController::class, 'export'])->name('export');
            Route::get('/{donation}', [DonationController::class, 'show'])->name('show');
            Route::get('/{donation}/edit', [DonationController::class, 'edit'])->name('edit');
            Route::put('/{donation}', [DonationController::class, 'update'])->name('update');
            Route::delete('/{donation}', [DonationController::class, 'destroy'])->name('destroy');
            
            // Rutas adicionales para flujos de estado
            Route::post('/{donation}/confirm', [DonationController::class, 'confirm'])->name('confirm');
            Route::post('/{donation}/process', [DonationController::class, 'process'])->name('process');
            Route::post('/{donation}/reject', [DonationController::class, 'reject'])->name('reject');
            Route::post('/{donation}/cancel', [DonationController::class, 'cancel'])->name('cancel');
        });

        // PayPal
Route::post('/donations/paypal/create-order', [DonationController::class, 'createPaypalOrder'])
    ->name('donations.paypal.create');

Route::post('/donations/paypal/capture-order', [DonationController::class, 'capturePaypalOrder'])
    ->name('donations.paypal.capture');

        // ====== About Section ======
        Route::get('about', [AboutSectionController::class, 'index'])->name('about.index');
        Route::put('about/{id}', [AboutSectionController::class, 'update'])->name('about.update');

   // ====== Hero Section ======
Route::get('hero', [HeroSectionController::class, 'index'])->name('hero.index');
        Route::post('hero', [HeroSectionController::class, 'store'])->name('hero.store');
        Route::put('hero/{hero}', [HeroSectionController::class, 'update'])->name('hero.update');

        // ====== Project Index ======

        // ====== Project Index (admin listado rápido) ======
        Route::prefix('projects')->name('projects.')->group(function() {
            Route::get('/', [ProjectIndexController::class, 'indexAdmin'])->name('index');
            Route::patch('{project}/toggle', [ProjectIndexController::class, 'toggle'])->name('toggle');
            Route::delete('{project}', [ProjectIndexController::class, 'destroy'])->name('destroy');
        });

        // ====== Beneficiary Testimonials ======
        Route::get('testimonials', [BeneficiaryTestimonialController::class, 'index'])->name('testimonials.index');
        Route::post('testimonials', [BeneficiaryTestimonialController::class, 'store'])->name('testimonials.store');
        Route::put('testimonials/{testimonial}', [BeneficiaryTestimonialController::class, 'update'])->name('testimonials.update');
        Route::delete('testimonials/{testimonial}', [BeneficiaryTestimonialController::class, 'destroy'])->name('testimonials.destroy');
        Route::post('testimonials/{testimonial}/toggle-publish', [BeneficiaryTestimonialController::class, 'togglePublish'])->name('testimonials.toggle-publish');

        // ====== Sponsor Highlights ======
        Route::get('sponsors', [SponsorHighlightController::class, 'index'])->name('sponsors.index');
        Route::post('sponsors', [SponsorHighlightController::class, 'store'])->name('sponsors.store');
        Route::put('sponsors/{highlight}', [SponsorHighlightController::class, 'update'])->name('sponsors.update');
        Route::delete('sponsors/{highlight}', [SponsorHighlightController::class, 'destroy'])->name('sponsors.destroy');
        Route::post('sponsors/{highlight}/toggle-publish', [SponsorHighlightController::class, 'togglePublish'])->name('sponsors.toggle-publish');

        // ====== Donor Highlights ======
        Route::get('donors', [DonorHighlightController::class, 'index'])->name('donors.index');
        Route::post('donors', [DonorHighlightController::class, 'store'])->name('donors.store');
        Route::put('donors/{highlight}', [DonorHighlightController::class, 'update'])->name('donors.update');
        Route::delete('donors/{highlight}', [DonorHighlightController::class, 'destroy'])->name('donors.destroy');
        Route::post('donors/{highlight}/toggle-publish', [DonorHighlightController::class, 'togglePublish'])->name('donors.toggle-publish');
    });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/index2', [HomeController::class, 'index2'])->name('home.alt');

