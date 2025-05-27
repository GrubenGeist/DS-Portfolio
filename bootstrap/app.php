<?php
use App\Providers\AuthServiceProvider;
use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance']);
        $middleware->statefulApi();
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
        // --- HIER DIE FEHLENDEN ALIASE HINZUFÜGEN ---
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            // Füge hier ggf. weitere Aliase hinzu, die du brauchst,
            // z.B. wenn 'auth' oder 'verified' nicht automatisch funktionieren:
            // 'auth' => \App\Http\Middleware\Authenticate::class, // Pfad ggf. anpassen
            // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);
        // --- Ende der Alias-Definition ---
        //    // app/Http/Kernel.php (Beispiel für L10)
        //'api' => [
        //    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        //    // ... andere api middleware
        //],
    })


    ->withProviders([
        AuthServiceProvider::class, // Stellt sicher, dass dieser Provider geladen wird
        App\Providers\RouteServiceProvider::class,
        // Hier ggf. andere Provider hinzufügen, die du explizit brauchst
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
