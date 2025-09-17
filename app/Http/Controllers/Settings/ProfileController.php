<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Hash;      // <-- NEU: Import für Passwort-Hashing
use Illuminate\Validation\Rules\Password;  // <-- NEU: Import für Passwort-Regeln

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): InertiaResponse
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            // HINZUGEFÜGT: Breadcrumbs sind wichtig für die Navigation
            'breadcrumbs' => [
                ['label' => 'Einstellungen'],
            ],
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validatedData = $request->validated();
        
        $emailIsDirty = isset($validatedData['email']) && $user->email !== $validatedData['email'];
        
        $user->update($validatedData);

        if ($emailIsDirty) {
            $user->email_verified_at = null;
            $user->save();
        }

        return Redirect::route('settings.profile.edit')->with('success', 'Profil erfolgreich aktualisiert.');
    }

    /**
     * Methode zur Aktualisierung des Passworts.
     * Die Logik wurde aus dem alten PasswordController hierher verschoben.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Passwort erfolgreich geändert.');
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