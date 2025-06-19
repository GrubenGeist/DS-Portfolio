<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PageController;   // Für Admin-Benutzerverwaltung
// Für Benutzerprofile
use Illuminate\Support\Facades\Route;        // Für allgemeine Seiten

// --- Öffentliche Routen (für Gäste und eingeloggte User) ---
// Werden jetzt vom PageController bedient
Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('contactform', [PageController::class, 'contactForm'])->name('Kontaktformular');

// --- Routen, die Login erfordern ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (Nur für Admin) -> PageController
    Route::get('dashboard', [PageController::class, 'dashboard'])
        ->name('dashboard')
        ->middleware('role:Admin');

    // Testseite (Admin ODER Company) -> PageController
    Route::get('test', [PageController::class, 'testPage'])
        ->name('test') // Name 'test' wie in deiner alten web.php
        ->middleware('role:Admin|Company');

    // Projekte (Admin ODER Company) -> PageController
    Route::get('projects', [PageController::class, 'projects'])
        ->name('projects')
        ->middleware('role:Admin|Company');

    // Dienstleistungen (Admin ODER Company) -> PageController
    Route::get('services', [PageController::class, 'services'])
        ->name('services')
        ->middleware('role:Admin|Company');

    // Über Mich (Admin ODER Company) -> PageController
    Route::get('aboutme', [PageController::class, 'aboutMe'])
        ->name('aboutme')
        ->middleware('role:Admin|Company');

}); // Ende der auth & verified Gruppe

// --- Admin-Bereich (für Benutzerverwaltung durch UserController) ---
// Dieser Teil bleibt strukturell wie in deiner "alten web.php"
Route::middleware(['auth', 'verified', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('users.editRole');
        Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        // Weitere spezifische Admin-Routen, die den UserController nutzen...
    });

// --- Include weiterer Routen-Dateien ---
// Diese Zeilen übernimmst du aus deiner "alten web.php"
if (file_exists(__DIR__.'/settings.php')) { // Gute Praxis: Existenz prüfen
    require __DIR__.'/settings.php';
}
require __DIR__.'/auth.php'; // Für Login, Passwort Reset, etc. von Laravel

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
