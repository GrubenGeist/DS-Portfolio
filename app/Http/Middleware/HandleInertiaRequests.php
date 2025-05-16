<?php

namespace App\Http\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Route as LaravelRoute;

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
        [$message, $author] = str(\Illuminate\Foundation\Inspiring::quotes()->random())->explode('-'); // Illuminate\Foundation\Inspiring für Inspiring::quotes()
    
        $loggedInUser = $request->user(); // Benutzer einmal holen
    
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $loggedInUser ? [
                    'id' => $loggedInUser->id,
                    'name' => $loggedInUser->name,
                    'email' => $loggedInUser->email,
                    'roles' => $loggedInUser->getRoleNames()->toArray(), // ->toArray() ist gut für Konsistenz
                    // ---- HIER DIE NEUEN FELDER HINZUFÜGEN ----
                    'avatar' => $loggedInUser->avatar ?? null, // Beispiel, falls du ein Avatar-Feld hast
                    'email_verified_at' => $loggedInUser->email_verified_at ? $loggedInUser->email_verified_at->toIso8601String() : null,
                    'created_at' => $loggedInUser->created_at ? $loggedInUser->created_at->toIso8601String() : null,
                    'updated_at' => $loggedInUser->updated_at ? $loggedInUser->updated_at->toIso8601String() : null,
                ] : null,
            ],
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'canRegister' => LaravelRoute::has('register'),
        ];
    }
}
