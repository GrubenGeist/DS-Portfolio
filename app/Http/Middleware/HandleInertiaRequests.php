<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route as LaravelRoute;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    
    /**
     * The root template that's loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $loggedInUser = $request->user();

        return [
            ...parent::share($request),
            // Wir fügen das CSRF-Token hinzu, damit 'fetch' es verwenden kann.
            'csrf_token' => csrf_token(),

            'auth' => [
                'user' => $loggedInUser ? [
                    'id' => $loggedInUser->id,
                    'first_name' => $loggedInUser->first_name,
                    'last_name' => $loggedInUser->last_name,
                    'company'=>$loggedInUser->company,
                    'name' => $loggedInUser->name,
                    'email' => $loggedInUser->email,
                    'roles' => $loggedInUser->getRoleNames()->toArray(),
                    'avatar' => $loggedInUser->avatar ?? null,
                    'email_verified_at' => $loggedInUser->email_verified_at ? $loggedInUser->email_verified_at->toIso8601String() : null,
                    'created_at' => $loggedInUser->created_at ? $loggedInUser->created_at->toIso8601String() : null,
                    'updated_at' => $loggedInUser->updated_at ? $loggedInUser->updated_at->toIso8601String() : null,
                ] : null,
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'canRegister' => LaravelRoute::has('register'),
            
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            
            // Hier laden wir die Sprache und die Übersetzungen
            'locale' => fn () => app()->getLocale(),
            
            'translations' => function () {
                $translations = [];
                // Greift auf unsere config/localization.php zu
                foreach (config('localization.supported_locales', ['en', 'de']) as $locale) {
                    $path = lang_path("{$locale}.json");

                    if (File::exists($path)) {
                        $translations[$locale] = json_decode(File::get($path), true);
                    }
                }
                return $translations;
            },
        ];
    }
}