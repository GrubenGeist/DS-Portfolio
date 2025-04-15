<?php

namespace App\Http\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                // Prüfen ob User eingeloggt ist
                'user' => $request->user() ? [
                    // Nur spezifische, bekannte Daten übergeben
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    // Hier holen wir die Rollen explizit mit der Spatie-Methode
                    // Das gibt ein Array mit Rollen-Namen zurück, z.B. ['Admin']
                    'roles' => $request->user()->getRoleNames(),
                    // Optional: Wenn du Permissions brauchst:
                    // 'permissions' => $request->user()->getPermissionNames(),
                ] : null, // Wenn nicht eingeloggt, ist user null
            ],
            // DIESER TEIL IST KORREKT FÜR ZIGGY:
            'ziggy' => [
                ...(new Ziggy)->toArray(), // Holt alle Routen von Ziggy
                'location' => $request->url(), // Fügt die aktuelle URL hinzu
            ],
            // ENDE DES ZIGGY-TEILS
        ];
    }
}
