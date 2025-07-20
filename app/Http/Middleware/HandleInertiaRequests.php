<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as LaravelRoute;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

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
        [$message, $author] = str(\Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');

        $loggedInUser = $request->user();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $loggedInUser ? [
                    'id' => $loggedInUser->id,
                    'name' => $loggedInUser->name,
                    'email' => $loggedInUser->email,
                    'roles' => $loggedInUser->getRoleNames()->toArray(),
                    'avatar' => $loggedInUser->avatar ?? null,
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
            
            // KORREKTUR: Dieser Block wurde zu deinen bestehenden geteilten Daten hinzugefügt.
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
        ];
    }
}
