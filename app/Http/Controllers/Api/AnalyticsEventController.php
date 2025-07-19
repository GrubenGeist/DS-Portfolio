<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category; // WICHTIG: Das neue Category-Model importieren
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsEventController extends Controller
{
    /**
     * Speichert ein neues Analytics-Event.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'label' => 'required|string|max:255',
        ]);

        $categoryId = null;

        // Prüfen, ob eine Kategorie übergeben wurde.
        if (!empty($validated['category'])) {
            // Finde die Kategorie anhand ihres Namens. Wenn sie nicht existiert,
            // wird sie automatisch neu in der 'categories'-Tabelle angelegt.
            $category = Category::firstOrCreate(
                ['name' => $validated['category']]
            );
            // Wir holen uns die ID der gefundenen oder neu erstellten Kategorie.
            $categoryId = $category->id;
        }

        // Speichere das Event in der Datenbank mit der neuen 'category_id'.
        DB::table('analytics_events')->insert([
            'label' => $validated['label'],
            'category_id' => $categoryId, // Die neue Spalte wird hier verwendet
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Event tracked.'], 201);
    }
}
