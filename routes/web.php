<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController; // Sicherstellen, dass der Pfad korrekt ist
use App\Http\Controllers\ProfileController; // Import hinzugefügt

// --- Öffentliche Routen ---
// Zugänglich für Gäste, Company, Admin
// keine middleware = öffentlich
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('contactform', function () {
    return Inertia::render('Contactform');
})->name('Kontaktformular');

// --- Routen, die Login erfordern ---
// Gruppieren wir sie für bessere Übersicht
Route::middleware(['auth', 'verified'])->group(function () {

    // +++ VERSCHOBEN +++ Profil-Routen hierhin verschoben (benötigen Authentifizierung)
    // Route zum Anzeigen/Bearbeiten des Profils des eingeloggten Benutzers
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Optional, aber oft nützlich: Routen zum Aktualisieren und Löschen des Profils
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // +++ ENDE VERSCHOBEN +++

    //Nur für Admin Zugänglich
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard')->middleware('role:Admin');

    // --- AUSKOMMENTIERT --- Grund: Doppelte Definition mit gleichem Namen 'testseite' weiter unten.
    // Route::get('test', function () {
    //     return Inertia::render('Test');
    // })->name('testseite')->middleware('role:Admin');
    // --- ENDE AUSKOMMENTIERT ---

    // -- Zugänglich für ALLE eingeloggten (Admin, Company) --
    /*Route::get('contactform', function () {
        return Inertia::render('Contactform');
    })->name('Kontaktformular');*/


    // -- Zugänglich für Admin ODER Company --
    // HINWEIS: Diese Route hat denselben Namen 'testseite' wie die auskommentierte oben.
    // Laravel registriert normalerweise nur die letzte Definition mit einem Namen.
    // Diese hier erlaubt Admin ODER Company, was vermutlich gewünscht ist.
    Route::get('test', function () {
        return Inertia::render('Test');
    })->name('test')
        ->middleware('role:Admin|Company'); // Erlaube Admin ODER Company

    Route::get('projects', function () {
        return Inertia::render('Projects');
    })->name('projects')
        ->middleware('role:Admin|Company'); // Erlaube Admin ODER Company

    Route::get('services', function () {
        return Inertia::render('Services');
    })->name('services')
        ->middleware('role:Admin|Company'); // Erlaube Admin ODER Company

    Route::get('aboutme', function () {
        return Inertia::render('Aboutme');
    })->name('aboutme')
        ->middleware('role:Admin|Company'); // Erlaube Admin ODER Company

}); // Ende der auth & verified Gruppe


// --- Admin-Bereich ---
// Wichtig: Rolle auf 'Admin' (groß) geändert, passend zum Seeder und Gate::before
Route::middleware(['auth', 'verified', 'role:Admin']) // Rolle angepasst auf 'Admin'
    ->prefix('admin') // Prefix bleibt
    ->name('admin.') // Routennamen-Prefix hinzufügen für Klarheit (optional aber gut)
    ->group(function () {
        // Routennamen werden jetzt admin.users.index etc.
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('users.editRole');
        Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Hier könnten weitere Admin-Routen hinzukommen
        // Beispiel: Route für das Erstellen von Usern (geschützt durch Permission)
        // Route::get('/users/create', [UserController::class, 'create'])
        //       ->name('users.create')
        //       ->middleware('can:create user'); // Braucht Permission 'create user'
        // Route::post('/users', [UserController::class, 'store'])
        //       ->name('users.store')
        //       ->middleware('can:create user');
});


// --- Include weiterer Routen-Dateien ---
// HINWEIS: Stelle sicher, dass 'settings.php' und 'auth.php' keine Routen definieren,
// die mit den hier definierten kollidieren (insbesondere die Profil-Routen, falls Breeze/Jetstream genutzt wurde).
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';



//Verfügbare Benutzer Rollen
/**
 * ---------------------------------------
 * |id:  | Bezeichnung:  | Slug:         |
 * |-------------------------------------|
 * |id_1 | Administrator | Admin         |
 * |id_2 | Company       | Company       |
 * |     | Gast(user)    | Gast(User)    |
 * ---------------------------------------
 * bspw.: ->middleware(['auth', 'verified', 'role:betrieb'])
 * als Parameter
 */