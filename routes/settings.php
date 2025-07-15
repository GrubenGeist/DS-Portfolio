<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\SettingsController;
use Inertia\Inertia;

// Alle Routen in dieser Datei sind geschützt und haben das 'settings.'-Präfix
Route::middleware(['auth', 'verified'])
    ->prefix('settings')
    ->name('settings.')
    ->group(function () {
        
        Route::get('/', [SettingsController::class, 'index'])->name('index');

        // Profil-Routen
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Passwort-Routen
        Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        // Appearance-Route
        Route::get('appearance', function () {
            return Inertia::render('settings/Appearance', [
                'breadcrumbs' => [
                    ['label' => 'Einstellungen', 'href' => route('settings.index')],
                    ['label' => 'Erscheinungsbild'],
                ],
            ]);
        })->name('appearance');
    });