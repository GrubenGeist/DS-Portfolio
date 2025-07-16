<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsEventController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'label' => 'nullable|string|max:255',
            'value' => 'nullable|integer',
        ]);

        DB::table('analytics_events')->insert([
            'action' => $validated['action'],
            'category' => $validated['category'],
            'label' => $validated['label'] ?? null,
            'value' => $validated['value'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Event stored.'], 201);
    }
}
