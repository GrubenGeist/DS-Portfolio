<?php

namespace App\Http\Controllers;

// Ggf. Request-Klasse für Validierung beim Update importieren
// use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Zeigt das Profil-Formular des Benutzers an.
     */
    public function edit(Request $request): Response
    {
        // Gib die Inertia-View zurück.
        // 'Profile/Edit' ist der Pfad zur Vue-Komponente unter resources/js/Pages/
        return Inertia::render('Profile/Edit', [
            // Diese Props werden an die Vue-Komponente übergeben:
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => $request->user() // Die Daten des eingeloggten Benutzers
        ]);
    }

    /**
     * Aktualisiert die Profilinformationen des Benutzers.
     * (Hier nur als Platzhalter, Logik ggf. aus Breeze/Jetstream übernehmen)
     */
    public function update(Request $request): RedirectResponse // Beispiel mit ProfileUpdateRequest
    {
        // --- Provisorisch ---
        // Logik hier einfügen! Siehe Breeze/Jetstream für vollständiges Beispiel.
        return Redirect::route('profile.edit')->with('status', 'profile-updated-placeholder');
        // --- Ende Provisorisch ---
    }

    /**
     * Löscht den Account des Benutzers.
     * (Hier nur als Platzhalter)
     */
    public function destroy(Request $request): RedirectResponse
    {
        // --- Provisorisch ---
         return Redirect::to('/'); // Beispiel
        // --- Ende Provisorisch ---
    }
}