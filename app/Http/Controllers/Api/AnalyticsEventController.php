<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AnalyticsEventController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        if ($request->header('DNT') === '1') {
            return response()->noContent();
        }
    
        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'label'    => 'required|string|max:255',
        ]);
    
        $categoryId = null;
        if (!empty($validated['category'])) {
            // Finde die Kategorie oder erstelle sie, falls sie nicht existiert
            $category = Category::firstOrCreate(['name' => $validated['category']]);
            $categoryId = $category->id;
        }
    
        // Speichere das Event mit den korrekten Spaltennamen
        AnalyticsEvent::create([
            'action'      => 'click', // Standard-Aktion
            'label'       => $validated['label'],
            'category_id' => $categoryId,
        ]);
    
        return response()->json(['message' => 'Event tracked.'], 201);
    }
}