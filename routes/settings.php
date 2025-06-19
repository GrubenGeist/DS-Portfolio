<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified']) // 'verified' hier hinzufügen, wenn alle Settings-Seiten es erfordern
    ->prefix('settings')                // URL-Präfix /settings/...
    ->name('settings.')                 // Routennamen-Präfix settings....
    ->group(function () {

        // wenn /settings eine Standard-Unterseite haben soll.
        Route::get('/', [SettingsController::class, 'index'])->name('index'); // Leitet /settings zu /settings/profile

        // Profil-Routen
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // PasswordController-Routen
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
        })->name('appearance'); // settings.appearance

        // Diese Routen sind nur für Admins zugänglich
        Route::middleware(['role:Admin'])->prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index'); // Ergibt: settings.users.index
            Route::get('/{user}/edit-role', [UserController::class, 'editRole'])->name('editRole'); // settings.users.editRole
            Route::put('/{user}/update-role', [UserController::class, 'updateRole'])->name('updateRole'); // settings.users.updateRole
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy'); // settings.users.destroy
        });

    });
