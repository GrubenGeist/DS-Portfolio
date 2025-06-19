<?php

// app/Http/Controllers/SettingsController.php

namespace App\Http\Controllers;

// use Illuminate\Http\Request; // Falls benötigt
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SettingsController extends Controller
{
    /**
     * Zeigt die Haupt-Einstellungsseite an.
     */
    public function index(): InertiaResponse
    {
        // Hole alle Daten, die die Haupt-Settings-Seite eventuell braucht
        // Für eine reine Übersichtsseite mit Links sind vielleicht keine speziellen Daten nötig,
        // außer den Breadcrumbs.

        return Inertia::render('settings/index', [ // Name der neuen Vue-Komponente
            'breadcrumbs' => [
                ['label' => 'Einstellungen'], // Die aktuelle Seite
            ],
            // Du könntest hier auch Statusinformationen oder ähnliches übergeben
        ]);
    }
}
