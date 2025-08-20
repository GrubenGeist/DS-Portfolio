<?php

// /app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hole die Sprache aus der Session. Wenn keine gesetzt ist, nimm den Standardwert aus der Konfig.
        $locale = session('locale', config('app.locale', 'en'));
        
        // Setze die Sprache für die aktuelle Anfrage im Backend
        App::setLocale($locale);

        return $next($request);
    }
}