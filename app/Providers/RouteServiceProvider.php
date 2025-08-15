<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Zielroute nach dem Login (falls verwendet).
     */
    public const HOME = '/';

    /**
     * Route-Gruppen registrieren.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // API-Routen (bekommen automatisch das Prefix /api)
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Web-Routen
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Rate Limiter konfigurieren.
     */
    protected function configureRateLimiting(): void
    {
        // Standard-Limiter für API (z. B. JSON-APIs)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // ➜ Dedizierter Limiter für Tracking-Events (GhostButton etc.)
        RateLimiter::for('track-events', function (Request $request) {
            // Passe die Rate gerne an deinen Bedarf an (z. B. 20/min/IP)
            return Limit::perMinute(20)->by($request->ip());
        });
    }
}
