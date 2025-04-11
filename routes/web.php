<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('test', function () {
    return Inertia::render('Test');
})->middleware(['auth', 'verified'])->name('testseite');

Route::get('aboutme', function () {
    return Inertia::render('Aboutme');
})->middleware([])->name('Über Mich');

Route::get('projects', function () {
    return Inertia::render('Projects');
})->middleware(['auth', 'verified'])->name('Projekte');

Route::get('services', function () {
    return Inertia::render('Services');
})->middleware(['auth', 'verified'])->name('Dienstleistungen');

Route::get('contactform', function () {
    return Inertia::render('Contactform');
})->middleware(['auth', 'verified'])->name('Kontaktformular');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('admin.users.editRole');
    Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';


//Verfügbare Benutzer Rollen

/**
 * ---------------------------------
 * |id:  | Bezeichnung:  | Slug:   |
 * |-------------------------------|
 * |id_1 | Administrator | admin   |
 * |id_2 | Betrieb       | betrieb |
 * |id_3 | Gast          | gast    |
 * ---------------------------------
 * bspw.: ->middleware(['auth', 'verified', 'role:betrieb'])
 * als Parameter
 */