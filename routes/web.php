<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
