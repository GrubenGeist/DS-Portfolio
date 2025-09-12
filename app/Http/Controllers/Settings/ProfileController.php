<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest; // Wichtig: Den neuen Request verwenden
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): InertiaResponse
    {
        // Rendert jetzt die korrekte Vue-Komponente.
        // Das 'user'-Objekt müssen wir nicht mehr manuell übergeben, Inertia macht das global.
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),

        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validatedData = $request->validated();

        // Prüfen, ob die E-Mail geändert wird, BEVOR wir updaten
        $emailIsDirty = isset($validatedData['email']) && $user->email !== $validatedData['email'];

        // Führe das Update durch
        $user->update($validatedData);

        // Setze die Verifizierung zurück, WENN die E-Mail geändert wurde
        if ($emailIsDirty) {
            $user->email_verified_at = null;
            $user->save();
        }

        return Redirect::route('settings.profile.edit')->with('success', 'Profil erfolgreich aktualisiert.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}