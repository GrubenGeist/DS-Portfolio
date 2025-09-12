<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\AppearanceController;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])
    ->prefix('settings')
    ->name('settings.')
    ->group(function () {
        
        // Profil
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Passwort
        Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        // Erscheinungsbild
        Route::get('appearance', [AppearanceController::class, 'edit'])->name('appearance.edit');
        Route::post('appearance', [AppearanceController::class, 'update'])->name('appearance.update');
    });