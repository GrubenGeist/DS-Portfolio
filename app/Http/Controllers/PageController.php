<?php

namespace App\Http\Controllers;

use App\Models\User; // **WICHTIG: User-Model importieren**
use App\Models\Category;
use Illuminate\Support\Facades\Log; // **WICHTIG: Log-Fassade importieren**
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse; // Für route() in Breadcrumbs
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
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
    // Ruft die Helfer-Methode auf, um alle initialen Statistik-Daten zu laden
        $stats = $this->getDashboardData($request);

        // Übergibt alle Daten an das Frontend
        return Inertia::render('Dashboard', [
            'initialUsers' => $usersForDashboard,
            'filters' => $request->only(['show_all', 'analytics_year', 'analytics_month', 'analytics_category', 'visitor_year', 'visitor_month']),
            'stats' => $stats['stats'],
            'analyticsData' => $stats['analyticsData'],
            'visitorData' => $stats['visitorData'],
        ]);
    }

    public function dashboardData(Request $request): JsonResponse
    {
        $data = $this->getDashboardData($request);
        return response()->json($data);
    }

    // Die private Helfer-Methode wird komplett überarbeitet
    private function getDashboardData(Request $request): array
    {
        // --- CONSENT-STATISTIKEN ---
        $totalConsents = DB::table('consent_events')->count();
        $analyticsAcceptance = $totalConsents > 0 ? round((DB::table('consent_events')->where('analytics_given', true)->count() / $totalConsents) * 100) : 0;
        
        // --- ANALYTICS-DATEN mit Filtern ---
        $analyticsYear = $request->input('analytics_year', now()->year);
        // NEU: Der Standard ist jetzt 'all'
        $analyticsMonth = $request->input('analytics_month', 'all'); 
        $analyticsCategoryId = $request->input('analytics_category_id', 'all');

        $clicksQuery = DB::table('analytics_events')
            ->whereYear('analytics_events.created_at', $analyticsYear);

        // NEU: Die Bedingung prüft jetzt auf 'all'
        if ($analyticsMonth && $analyticsMonth !== 'all') {
            $clicksQuery->whereMonth('analytics_events.created_at', $analyticsMonth);
        }
        
        if ($analyticsCategoryId && $analyticsCategoryId !== 'all') {
            $clicksQuery->where('analytics_events.category_id', $analyticsCategoryId);
        }

        $clicksHistory = $clicksQuery->select('label', DB::raw('count(*) as total'))
            ->groupBy('label')
            ->orderByDesc('total')
            ->orderBy('label', 'asc')
            ->get();
            
        $availableAnalyticsYears = DB::table('analytics_events')->select(DB::raw('YEAR(created_at) as year'))->distinct()->orderByDesc('year')->pluck('year');
        $availableAnalyticsCategories = Category::orderBy('name')->get(['id', 'name']);
        $totalClicksToday = DB::table('analytics_events')->whereDate('created_at', Carbon::today())->count();

        // --- BESUCHER-STATISTIKEN (unverändert) ---
        $activeVisitors = DB::table('visits')->where('visited_at', '>=', now()->subMinutes(5))->distinct('visitor_id')->count('visitor_id');
        $visitorYear = $request->input('visitor_year', now()->year);
        $visitorMonth = $request->input('visitor_month', now()->month);
        
        $visitsQuery = DB::table('visits')->whereYear('visited_at', $visitorYear);
        if ($visitorMonth) {
            $visitsQuery->whereMonth('visited_at', $visitorMonth);
        }
        $visitsHistory = $visitsQuery->select(DB::raw('DATE(visited_at) as date'), DB::raw('count(distinct visitor_id) as unique_visitors'))->groupBy('date')->orderBy('date')->get();
        $availableVisitorYears = DB::table('visits')->select(DB::raw('YEAR(visited_at) as year'))->distinct()->orderByDesc('year')->pluck('year');

        return [
            'stats' => ['totalConsents' => $totalConsents, 'analyticsAcceptanceRate' => $analyticsAcceptance],
            'analyticsData' => [
                'history' => $clicksHistory, 
                'availableYears' => $availableAnalyticsYears,
                'availableCategories' => $availableAnalyticsCategories,
                'totalToday' => $totalClicksToday,
                'filters' => [
                    'year' => (int)$analyticsYear, 
                    // NEU: Gibt den korrekten Wert zurück (kann 'all' sein oder eine Zahl)
                    'month' => $analyticsMonth === 'all' ? 'all' : (int)$analyticsMonth, 
                    'category_id' => $analyticsCategoryId === 'all' ? 'all' : (int)$analyticsCategoryId
                ]
            ],
            'visitorData' => [
                'activeNow' => $activeVisitors, 
                'history' => $visitsHistory,
                'availableYears' => $availableVisitorYears,
                'filters' => ['year' => (int)$visitorYear, 'month' => (int)$visitorMonth]
            ]
        ];
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

