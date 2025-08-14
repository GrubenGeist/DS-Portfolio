<?php

// Schritt 5: Passe die HandleAppearance Middleware an
// ==================================================
// In /app/Http/Middleware/HandleAppearance.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleAppearance
{
    /**
     * Diese Middleware hat jetzt keine aktive Rolle mehr beim Setzen von Cookies.
     * Ihre Hauptaufgabe ist es, bei serverseitigem Rendering (falls relevant)
     * das Cookie zu lesen. Die Logik bleibt einfach.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Die Logik hier ist für den aktuellen Anwendungsfall nicht mehr kritisch,
        // da das Frontend das Theme sofort über localStorage setzt.
        // Wir behalten sie als Fallback.
        return $next($request);
    }
}