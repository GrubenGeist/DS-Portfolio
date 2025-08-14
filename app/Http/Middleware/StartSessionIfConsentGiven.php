<?php
// Ersetze den gesamten Inhalt der neu erstellten Datei unter:
// /app/Http/Middleware/StartSessionIfConsentGiven.php

namespace App\Http\Middleware;

use Illuminate\Session\Middleware\StartSession;
use Illuminate\Http\Request;
use Closure;

class StartSessionIfConsentGiven extends StartSession
{
    /**
     * Überschreibt die Standard-Methode von Laravel.
     */
    public function handle($request, Closure $next)
    {
        // Startet die Session nur, wenn die Bedingungen in shouldStartSession() erfüllt sind.
        if ($this->sessionConfigured() && $this->shouldStartSession($request)) {
            return parent::handle($request, $next);
        }

        // Andernfalls wird die Anfrage ohne Session weitergeleitet.
        return $next($request);
    }

    /**
     * Definiert die Bedingung, unter der eine Session gestartet werden darf.
     */
    protected function shouldStartSession(Request $request): bool
    {
        // Gibt nur 'true' zurück (und startet damit die Session),
        // wenn unser Signal-Cookie 'laravel_consent' vom Frontend gesetzt wurde.
        return $request->hasCookie('laravel_consent');
    }
}