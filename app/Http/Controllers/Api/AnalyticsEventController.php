<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsEventController extends Controller
{
    /**
     * Speichert ein neues Analytics-Event.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // ➜ Do Not Track (DNT) sofort respektieren – nichts validieren/speichern
        if ($request->header('DNT') === '1') {
            return response()->noContent(); // 204
        }
    
        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'label'    => 'required|string|max:255',
        ]);
    
        $categoryId = null;
        if (!empty($validated['category'])) {
            $category = Category::firstOrCreate(['name' => $validated['category']]);
            $categoryId = $category->id;
        }
    
        DB::table('analytics_events')->insert([
            'action'      => 'click',
            'label'       => $validated['label'],
            'category_id' => $categoryId,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    
        return response()->json(['message' => 'Event tracked.'], 201);
    }
}
