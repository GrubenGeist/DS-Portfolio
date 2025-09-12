<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;


class AppearanceController extends Controller
{
    public function edit(): InertiaResponse
    {
        return Inertia::render('settings/Appearance', [
            'breadcrumbs' => [
                ['label' => 'Einstellungen', 'href' => route('settings.profile.edit')],
                ['label' => 'Erscheinungsbild'],
            ],
        ]);
    }

    /**
     * Update the user's appearance settings.
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. Nur das 'theme'-Feld validieren.
        $validated = $request->validate([
            'theme' => ['required', 'string', Rule::in(['light', 'dark', 'system'])],
        ]);

        // 2. Den authentifizierten Benutzer holen.
        $user = $request->user();

        // 3. Nur das validierte 'theme'-Feld in der Datenbank aktualisieren.
        $user->forceFill([
            'theme' => $validated['theme'],
        ])->save();

        return back()->with('success', 'Erscheinungsbild aktualisiert.');
    }
}