<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\TrackVisits;
use App\Http\Middleware\HandleInertiaRequests;
use App\Providers\AuthServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use App\Http\Middleware\StartSessionIfConsentGiven;
use App\Http\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // KORREKTUR 1: Fügt die Ausnahme für die CSRF-Prüfung hinzu.
        // Dies erlaubt der Consent-Anfrage, ohne Session-Cookie zu funktionieren.
        $middleware->validateCsrfTokens(except: [
            '/consent-event' 
        ]);

        // KORREKTUR 2: Ersetzt die Standard-Session-Logik durch unsere eigene.
        $middleware->replace(
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\StartSessionIfConsentGiven::class
        );

        $middleware->encryptCookies(except: ['appearance']);
        $middleware->statefulApi();
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
            TrackVisits::class,
            SetLocale::class, 
        ]);
        
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withProviders([
        AuthServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
    })->create();
