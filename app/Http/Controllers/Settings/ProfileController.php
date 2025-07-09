<?php

namespace App\Http\Controllers\Settings; // WICHTIG: Namespace angepasst

use App\Http\Controllers\Controller;     // Basis-Controller importieren
use App\Models\User;             // Request-Objekt importieren
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ProfileController extends Controller // Erbt vom Basis-Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): InertiaResponse
    {
        // Standard-Logik von Laravel Breeze/Jetstream oder deine eigene
        // Annahme: Die Vue-Komponente für das Profil ist 'Profile/Edit.vue'
        // oder 'Settings/ProfileEdit.vue' o.ä.

        $loggedInUser = Auth::user(); // **Benutzer holen**

        if (! $loggedInUser) {
            // Sollte durch Middleware abgedeckt sein, aber als Fallback
            return redirect()->route('login');
        }

        return Inertia::render('Profile/Edit', [ // **ANPASSEN: Stelle sicher, dass dies der korrekte Pfad zu deiner Edit.vue ist**
            // z.B. 'Settings/ProfileEdit' wenn sie dort liegt, oder nur 'ProfileEdit'
            // Aktiviere diese Zeilen, wenn du sie benötigst und MustVerifyEmail importiert ist
            // 'mustVerifyEmail' => $loggedInUser instanceof \Illuminate\Contracts\Auth\MustVerifyEmail,
            'status' => session('status'),
            'user' => [ // **HIER IST DIE FEHLENDE USER-PROP**
                'id' => $loggedInUser->id,
                'name' => $loggedInUser->name,
                'email' => $loggedInUser->email,
                // Füge hier alle weiteren Felder hinzu, die deine Edit.vue erwartet oder die du anzeigen möchtest
                // z.B. 'avatar' => $loggedInUser->avatar,
            ],
            'breadcrumbs' => [
                ['label' => 'Einstellungen', 'href' => route('settings.profile.edit')],
                ['label' => 'Profil bearbeiten'],
            ],
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request) // Rückgabetyp anpassen, oft RedirectResponse
    {
        // Validierung und Update-Logik
        // $request->user()->fill($request->validated());
        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }
        // $request->user()->save();
        // return Redirect::route('profile.edit');
        // Beispiel:
        // $validatedData = $request->validate([...]); // Deine Validierungsregeln
        // $request->user()->update($validatedData);
        return back()->with('success', 'Profil aktualisiert.'); // oder Redirect::route('profile.edit')
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request) // Rückgabetyp anpassen, oft RedirectResponse
    {
        // Logik zum Löschen des Accounts
        // $user = $request->user();
        // Auth::logout();
        // $user->delete();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // return Redirect::to('/');
        // Beispiel:
        // $request->validateWithBag('userDeletion', ['password' => ['required', 'current_password']]);
        // $user = $request->user();
        // Auth::logout();
        // $user->delete();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Account gelöscht.');
    }

    // Füge hier weitere Methoden hinzu, falls dein ProfileController mehr kann
}
