<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsentEventController extends Controller
{
    /**
     * Speichert ein neues Consent-Event.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'analytics' => 'required|boolean',
            // Hier könnten weitere Validierungen hinzukommen
        ]);

        DB::table('consent_events')->insert([
            'analytics_given' => $validated['analytics'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Consent recorded.'], 201);
    }
}
