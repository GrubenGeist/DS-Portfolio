<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BetriebController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\RegisteredUserController;

/*Route::get('/test-middleware', function () {
    return 'Test Page';
});
*/

    Route::get('/test-middleware', function () {
    dd('TestMiddleware hit!');
    })->middleware('auth');



// Routen, die Gäste sehen dürfen
/*Route::middleware(['guest'])->group(function () {

    Route::get('/test-middleware', function () {
    dd('TestMiddleware hit!');
    })->middleware('auth');

 /*   Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');


});

// Routen, die alle authentifizierten Benutzer sehen dürfen
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [Controller::class, 'index'])->name('home');
});

// Routen, die nur Administratoren sehen dürfen
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('test', function () {
        return Inertia::render('Test');
    })->middleware(['verified'])->name('testseite');

    Route::get('projects', function () {
        return Inertia::render('Projects');
    })->middleware(['verified'])->name('Projekte');

    Route::get('services', function () {
        return Inertia::render('Services');
    })->middleware(['verified'])->name('Dienstleistungen');

    Route::get('contactform', function () {
        return Inertia::render('Contactform');
    })->middleware(['verified'])->name('Kontaktformular');
});

// Routen, die nur Benutzer mit der Rolle "Betrieb" sehen dürfen
Route::middleware(['auth', 'role:betrieb'])->group(function () {
    
    Route::get('/betrieb/bereich1', [BetriebController::class, 'bereich1']); */
//});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';