<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\AnalyticsEventController;
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Api\ConsentEventController; 
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\AppearanceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ÖFFENTLICHE ROUTEN ---
Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/contactform', [PageController::class, 'contactform'])->name('contactform');
//Route::post('/track-event', [AnalyticsEventController::class, 'store'])->name('api.track-event');
Route::get('/impressum', [PageController::class, 'imprint'])->name('imprint');
Route::get('/datenschutz', [PageController::class, 'privacy'])->name('privacy');
Route::post('/update-appearance', [AppearanceController::class, 'update'])->name('appearance.update');

Route::post('/consent-event', [ConsentEventController::class, 'store'])->name('api.consent.store');
// --- GESCHÜTZTE ROUTEN ---
Route::middleware(['auth', 'verified'])->group(function () {
    // Allgemeine Seiten
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard')->middleware('role:Admin');
    Route::get('/projects', [PageController::class, 'projects'])->name('projects')->middleware('role:Admin|Company');
    Route::get('/services', [PageController::class, 'services'])->name('services')->middleware('role:Admin|Company');
    Route::get('/aboutme', [PageController::class, 'aboutMe'])->name('aboutme')->middleware('role:Admin|Company');
    
    // --- ADMIN-BEREICH (Benutzerverwaltung) ---
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('users.editRole');
        Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::resource('categories', CategoryController::class);
    });

    // --- API-ROUTEN FÜR DAS DASHBOARD ---
    // Diese Route ist jetzt auch geschützt und nur für eingeloggte Benutzer erreichbar.
    Route::get('/dashboard/data', [PageController::class, 'dashboardData'])->name('dashboard.data');

});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// --- WEITERE ROUTEN-DATEIEN LADEN ---
require __DIR__.'/auth.php';
require __DIR__.'/settings.php'; // Wir laden die Einstellungs-Routen wieder

/*
Verfügbare Benutzer Rollen (zur Information aus deiner alten web.php):
---------------------------------------
|id:  | Bezeichnung:   | Slug:         |
|-------------------------------------|
|id_1 | Administrator | Admin         |
|id_2 | Company       | Company       |
|     | Gast(user)    | Gast(User)    |
---------------------------------------
bspw.: ->middleware(['auth', 'verified', 'role:Company'])
*/


