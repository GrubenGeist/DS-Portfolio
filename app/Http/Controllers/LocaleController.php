<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleController extends Controller
{
    /**
     * Wechselt die Sprache für Inertia-Anfragen.
     * @deprecated Wird aufgrund von UI-Glitches in Inertia v2 nicht mehr aktiv genutzt.
     */
    public function switch(Request $request): Response
    {
        // Holt die erlaubten Sprachen aus unserer neuen Konfigurationsdatei
        $supportedLocales = config('localization.supported_locales', ['en', 'de']);

        // Validiert die eingehende Anfrage
        $validated = $request->validate([
            'locale' => ['required', 'string', 'in:' . implode(',', $supportedLocales)]
        ]);

        // Speichert die neue Sprache in der Session für zukünftige Anfragen
        session(['locale' => $validated['locale']]);

        // Sendet eine "204 No Content" Antwort.
        return response()->noContent();
    }

    /**
     * Wechselt die Sprache für API-Anfragen (z.B. per fetch).
     * Dies ist die neue, stabile Methode.
     */
    public function switchApi(Request $request): Response
    {
        // Holt die erlaubten Sprachen aus unserer neuen Konfigurationsdatei
        $supportedLocales = config('localization.supported_locales', ['en', 'de']);

        // Validiert die eingehende Anfrage
        $validated = $request->validate([
            'locale' => ['required', 'string', 'in:' . implode(',', $supportedLocales)]
        ]);

        // Speichert die neue Sprache in der Session für zukünftige Anfragen
        session(['locale' => $validated['locale']]);

        // Sendet eine einfache "OK"-Antwort an den fetch-Aufruf
        return response()->json(['success' => true]);
    }
}