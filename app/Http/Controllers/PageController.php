<?php

namespace App\Http\Controllers;

use App\Models\User; // **WICHTIG: User-Model importieren**
use Illuminate\Support\Facades\Log; // **WICHTIG: Log-Fassade importieren**
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse; // Für route() in Breadcrumbs
use Illuminate\Http\Request;
use Carbon\Carbon;

class PageController extends Controller
{
    public function welcome(): InertiaResponse
    {
        return Inertia::render('Welcome', [
            'breadcrumbs' => [['label' => 'Startseite', 'href' => route('welcome')]], // Vom Backend
        ]);
    }

    public function contactForm(): InertiaResponse
    {
        return Inertia::render('Contactform', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Kontaktformular'],
            ],
        ]);
    }

    public function dashboard(Request $request): InertiaResponse
    {
        $usersForDashboard = [];
        $errorLoadingUsers = null;
    
        try {
            // 1. Wir starten mit dem Query Builder.
            $query = User::query();
    
            // 2. Wende den Datumsfilter an, wenn die Checkbox NICHT gesetzt ist.
            if (!$request->boolean('show_all')) {
                $tenDaysAgo = Carbon::now()->subDays(10);
                $query->where('last_login_at', '>=', $tenDaysAgo);
            }
    
            // 3. Führe die (möglicherweise gefilterte) Abfrage aus UND lade die Rollen.
            //    WICHTIG: Wir arbeiten jetzt mit der $query-Variable weiter!
            $users = $query->with('roles')->get();
    
            // 4. Transformiere das Ergebnis der gefilterten Abfrage.
            $usersForDashboard = $users->map(function ($user) {
                $isOnline = $user->last_login_at && $user->last_login_at->gt(now()->subMinutes(5));
    
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'last_login_at' => $user->last_login_at,
                    'roles' => $user->roles->map(fn ($role) => ['name' => $role->name])->all(),
                    'is_online' => $isOnline,
                ];
            })->all();
    
        } catch (\Exception $e) {
            Log::error('Fehler beim Laden der Benutzer für das Dashboard: '.$e->getMessage());
            $errorLoadingUsers = 'Benutzerdaten konnten nicht geladen werden.';
        }
    
        return Inertia::render('Dashboard', [
            'initialUsers' => $usersForDashboard,
            'userFetchError' => $errorLoadingUsers,
            'filters' => [
                'show_all' => $request->boolean('show_all'),
            ]
        ]);
    }

    public function showAdminRegistrationForm(): InertiaResponse
    {
        return Inertia::render('register', [ // Stelle sicher, dass 'register.vue' existiert
            'breadcrumbs' => [['label' => 'Benutzer registrieren (Admin)']],
        ]);
    }

    public function testPage(): InertiaResponse
    {
        return Inertia::render('Test', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Testseite'],
            ],
        ]);
    }

    public function projects(): InertiaResponse
    {
        return Inertia::render('Projects', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Projekte'],
            ],
        ]);
    }

    public function services(): InertiaResponse
    {
        return Inertia::render('Services', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Dienstleistungen'],
            ],
        ]);
    }

    public function aboutMe(): InertiaResponse
    {
        return Inertia::render('Aboutme', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Über Mich'],
            ],
        ]);
    }
}
