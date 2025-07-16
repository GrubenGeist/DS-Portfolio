<?php
// Pfad zum Controller ggf. falls ein separater API-Controller erstellt
use App\Http\Controllers\Admin\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Wenn deine API z.B. Sanctum für SPA-Authentifizierung nutzt:
Route::middleware('auth:sanctum')->group(function () {

    // Deine Route für die Benutzerliste
    Route::get('/users', [UserController::class, 'indexApi']) // Verweist auf die Index-Methode
        ->name('api.users.index');                   

    // Hier könnten weitere API-Routen hinzukommen, z.B. für einen einzelnen User
    // Route::get('/users/{user}', [UserController::class, 'show'])->name('api.users.show');

});

// Eine Route, um den aktuell authentifizierten User abzufragen (Standard bei Sanctum-Setup)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
