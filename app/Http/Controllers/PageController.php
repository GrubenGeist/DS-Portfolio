<?php

namespace App\Http\Controllers;

use App\Models\User; // **WICHTIG: User-Model importieren**
use Illuminate\Support\Facades\Log; // **WICHTIG: Log-Fassade importieren**
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse; // Für route() in Breadcrumbs
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    // In app/Http/Controllers/PageController.php

public function dashboard(Request $request): InertiaResponse
{
    // --- BENUTZERDATEN LADEN ---
    $usersForDashboard = [];
    $errorLoadingUsers = null;
    try {
        $query = User::query();
        if (!$request->boolean('show_all')) {
            $tenDaysAgo = Carbon::now()->subDays(10);
            $query->where('last_login_at', '>=', $tenDaysAgo);
        }
        $users = $query->with('roles')->get();
        $usersForDashboard = $users->map(function ($user) {
            $isOnline = $user->last_login_at && $user->last_login_at->gt(now()->subMinutes(5));
            return [
                'id' => $user->id, 'name' => $user->name, 'email' => $user->email,
                'last_login_at' => $user->last_login_at,
                'roles' => $user->roles->map(fn ($role) => ['name' => $role->name])->all(),
                'is_online' => $isOnline,
            ];
        })->all();
    } catch (\Exception $e) {
        $errorLoadingUsers = 'Benutzerdaten konnten nicht geladen werden.';
    }

    // --- CONSENT-STATISTIKEN BERECHNEN ---
    $totalConsents = DB::table('consent_events')->count();
    $analyticsAcceptance = $totalConsents > 0
        ? round((DB::table('consent_events')->where('analytics_given', true)->count() / $totalConsents) * 100)
        : 0;
    
    $consentStats = [
        'totalConsents' => $totalConsents,
        'analyticsAcceptanceRate' => $analyticsAcceptance,
    ];

    // --- ANALYSE-DATEN BERECHNEN ---
    $clicksToday = DB::table('analytics_events')->whereDate('created_at', Carbon::today())->select('label', DB::raw('count(*) as total'))->groupBy('label')->orderByDesc('total')->get();
    $clicksThisMonth = DB::table('analytics_events')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->select('label', DB::raw('count(*) as total'))->groupBy('label')->orderByDesc('total')->get();
    $clicksThisYear = DB::table('analytics_events')->whereYear('created_at', Carbon::now()->year)->select('label', DB::raw('count(*) as total'))->groupBy('label')->orderByDesc('total')->get();

    // --- DATEN AN DAS FRONTEND ÜBERGEBEN ---
    return Inertia::render('Dashboard', [
        'initialUsers' => $usersForDashboard,
        'userFetchError' => $errorLoadingUsers,
        'filters' => $request->only(['show_all']),
        'stats' => $consentStats,
        'analyticsData' => [
            'today' => $clicksToday,
            'month' => $clicksThisMonth,
            'year' => $clicksThisYear,
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
