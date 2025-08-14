<?php

// Schritt 4: Fülle den neuen Controller mit Leben (angepasst für 'system')
// =======================================================================
// In /app/Http/Controllers/AppearanceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AppearanceController extends Controller
{
    public function update(Request $request)
    {
        // KORREKTUR: Die Validierung erlaubt jetzt auch 'system'
        $request->validate([
            'appearance' => 'required|in:light,dark,system',
        ]);

        $appearance = $request->input('appearance');

        // Das Backend setzt das Cookie. Die Middleware `StartSessionIfConsentGiven`
        // stellt sicher, dass dies nur nach der Zustimmung geschieht.
        Cookie::queue('appearance', $appearance, 60 * 24 * 365 * 5);

        return back();
    }
}