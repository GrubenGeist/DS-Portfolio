<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
// Ggf. nicht nötig, aber schadet nicht für Kontext
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     * Passe dies ggf. an deine Anwendung an.
     *
     * @var string
     */
    public const HOME = '/'; // Standard ist oft '/home' oder '/dashboard'

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // API Routen Konfiguration
            Route::middleware('api') // Wendet die 'api' Middleware Gruppe an
                ->prefix('api')     // Stellt allen Routen in api.php '/api' voran
                ->group(base_path('routes/api.php')); // Lädt die Routen aus routes/api.php

            // Web Routen Konfiguration
            Route::middleware('web') // Wendet die 'web' Middleware Gruppe an
                ->group(base_path('routes/web.php')); // Lädt die Routen aus routes/web.php
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Konfiguriert das Rate Limiting für API Anfragen
        RateLimiter::for('api', function (Request $request) {
            // Beispiel: 60 Anfragen pro Minute pro User oder IP-Adresse
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Beispiel für Web Rate Limiting (falls benötigt)
        /*
        RateLimiter::for('web', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });
        */
    }
}
