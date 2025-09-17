<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Carbon\Carbon;
use App\Models\Visit; // KORREKTUR: Fehlendes Model importiert
use App\Models\AnalyticsEvent; // KORREKTUR: Fehlendes Model importiert

class PageController extends Controller
{
    // ... (andere Methoden wie dashboard, welcome etc. bleiben unverändert)
    public function welcome(): InertiaResponse
  {
    return Inertia::render('Welcome', [
      'breadcrumbs' => [['label' => 'Startseite', 'href' => route('welcome')]],
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
        $initialData = $this->getDashboardData($request);
        
        // Deine Logik für die Benutzer-Tabelle (unverändert)
        $usersForDashboard = [];
        try {
            $query = User::query();
            if (!$request->boolean('show_all')) {
                $tenDaysAgo = Carbon::now()->subDays(10);
                $query->where('last_login_at', '>=', $tenDaysAgo);
            }
            $users = $query->with('roles')->get();
            $usersForDashboard = $users->map(function ($user) {
                return [
                    'id' => $user->id, 'name' => $user->name, 'email' => $user->email,
                    'last_login_at' => $user->last_login_at,
                    'roles' => $user->roles->map(fn ($role) => ['name' => $role->name])->all(),
                    'is_online' => $user->last_login_at && $user->last_login_at->gt(now()->subMinutes(5)),
                ];
            })->all();
        } catch (\Exception $e) {
            // Fehlerbehandlung
        }

        return Inertia::render('Dashboard', [
            'initialUsers' => $usersForDashboard,
            'filters' => $request->only(['show_all']),
            'stats' => $initialData['stats'],
            // Die Props wurden an die Namen in der `getDashboardData` Methode angepasst.
            'analyticsData' => $initialData['analyticsData'],
            'visitorData' => $initialData['visitorData'],
        ]);
    }

    public function dashboardData(Request $request): JsonResponse
    {
        $data = $this->getDashboardData($request);
        return response()->json($data);
    }

    private function getDashboardData(Request $request): array
    {
        // --- ANALYTICS-DATEN ---
        $analyticsYear = $request->input('analytics_year', now()->year);
        $analyticsMonth = $request->input('analytics_month', 'all'); 
        $analyticsCategoryId = $request->input('analytics_category_id', 'all');
        $clicksQuery = AnalyticsEvent::query()->whereYear('created_at', $analyticsYear);
        if ($analyticsMonth !== 'all') {
            $clicksQuery->whereMonth('created_at', $analyticsMonth);
        }
        if ($analyticsCategoryId !== 'all') {
            $clicksQuery->where('category_id', $analyticsCategoryId);
        }
        $clicksHistory = $clicksQuery->select('label', DB::raw('count(*) as total'))->groupBy('label')->orderByDesc('total')->get();
        
        $dbYears = AnalyticsEvent::query()->select(DB::raw('YEAR(created_at) as year'))->distinct()->pluck('year');
        $availableAnalyticsYears = $dbYears->push(now()->year)->unique()->sortDesc()->values();
        
        // KORREKTUR: Wir verwenden den korrekten Spaltennamen 'category_name'
        // und benennen ihn für das Frontend als 'name' um.
        $availableAnalyticsCategories = Category::orderBy('name')->get(['id', 'name']);
        
        $totalClicksToday = AnalyticsEvent::query()->whereDate('created_at', Carbon::today())->count();

        // --- BESUCHER-STATISTIKEN (KORRIGIERT) ---
        $activeVisitors = Visit::query()->where('last_seen', '>=', now()->subMinutes(5))->count();
        $visitorYear = $request->input('visitor_year', now()->year);
        $visitorMonth = $request->input('visitor_month', 'all');
        $visitorDeviceType = $request->input('visitor_device_type', 'all');
        
        $visitsQuery = Visit::query()->whereYear('created_at', $visitorYear);
        if ($visitorMonth !== 'all') {
            $visitsQuery->whereMonth('created_at', $visitorMonth);
        }
        if ($visitorDeviceType !== 'all') {
            $visitsQuery->where('device_type', $visitorDeviceType);
        }

        $visitsHistory = $visitsQuery->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw("SUM(CASE WHEN device_type = 'desktop' THEN 1 ELSE 0 END) as desktop"),
                DB::raw("SUM(CASE WHEN device_type = 'mobile' THEN 1 ELSE 0 END) as mobile")
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dbVisitorYears = Visit::query()->select(DB::raw('YEAR(created_at) as year'))->distinct()->pluck('year');
        $availableVisitorYears = $dbVisitorYears->push(now()->year)->unique()->sortDesc()->values();

        return [
            'stats' => ['totalConsents' => DB::table('consent_events')->count(), 'analyticsAcceptanceRate' => DB::table('consent_events')->count() > 0 ? round((DB::table('consent_events')->where('analytics_given', true)->count() / DB::table('consent_events')->count()) * 100) : 0],
            'analyticsData' => [
                'history' => $clicksHistory, 
                'availableYears' => $availableAnalyticsYears,
                'availableCategories' => $availableAnalyticsCategories,
                'totalToday' => $totalClicksToday,
                'filters' => ['year' => (int)$analyticsYear, 'month' => $analyticsMonth === 'all' ? 'all' : (int)$analyticsMonth, 'category_id' => $analyticsCategoryId === 'all' ? 'all' : (int)$analyticsCategoryId]
            ],
            'visitorData' => [
                'activeNow' => $activeVisitors, 
                'history' => $visitsHistory,
                'availableYears' => $availableVisitorYears,
                'filters' => ['year' => (int)$visitorYear, 'month' => $visitorMonth === 'all' ? 'all' : (int)$visitorMonth, 'device_type' => $visitorDeviceType]
            ]
        ];
    }

    // ... (restliche Methoden)
    public function showAdminRegistrationForm(): InertiaResponse
  {
    return Inertia::render('register', [
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

  public function imprint(): InertiaResponse
   {
       return Inertia::render('Imprint');
   }
   public function privacy(): InertiaResponse
   {
       return Inertia::render('Privacy');
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
  public function lebenslauf()
  {
      return inertia('LifeHistory'); // <-- genau so wie deine Vue-Komponente heißt
  }
}

# Neuer PageController.php
#<?php

# namespace App\Http\Controllers;
# 
# use App\Models\User;
# use App\Models\Category;
# use Illuminate\Http\Request;
# use Illuminate\Http\JsonResponse;
# use Illuminate\Support\Facades\DB;
# use Inertia\Inertia;
# use Inertia\Response as InertiaResponse;
# use Carbon\Carbon;
# 
# class PageController extends Controller
# {
#     // ===============================
#     // Spezielle Seiten mit Logik
#     // ===============================
# 
#     public function welcome(): InertiaResponse
#     {
#         return Inertia::render('Welcome', [
#             'breadcrumbs' => [['label' => 'Startseite', 'href' => route('welcome')]],
#         ]);
#     }
# 
#     public function dashboard(Request $request): InertiaResponse
#     {
#         $initialData = $this->getDashboardData($request);
#         $usersForDashboard = [];
# 
#         try {
#             $query = User::query();
# 
#             if (!$request->boolean('show_all')) {
#                 $tenDaysAgo = Carbon::now()->subDays(10);
#                 $query->where('last_login_at', '>=', $tenDaysAgo);
#             }
# 
#             $users = $query->with('roles')->get();
# 
#             $usersForDashboard = $users->map(function ($user) {
#                 return [
#                     'id' => $user->id,
#                     'name' => $user->name,
#                     'email' => $user->email,
#                     'last_login_at' => $user->last_login_at,
#                     'roles' => $user->roles->map(fn ($role) => ['name' => $role->name])->all(),
#                     'is_online' => $user->last_login_at && $user->last_login_at->gt(now()->subMinutes(5)),
#                 ];
#             })->all();
#         } catch (\Exception $e) {
#             // Fehlerbehandlung optional
#         }
# 
#         return Inertia::render('Dashboard', [
#             'initialUsers' => $usersForDashboard,
#             'filters' => $request->only(['show_all']),
#             'stats' => $initialData['stats'],
#             'analyticsData' => $initialData['analyticsData'],
#             'visitorData' => $initialData['visitorData'],
#         ]);
#     }
# 
#     public function dashboardData(Request $request): JsonResponse
#     {
#         $data = $this->getDashboardData($request);
#         return response()->json($data);
#     }
# 
#     private function getDashboardData(Request $request): array
#     {
#         // --- ANALYTICS-DATEN ---
#         $analyticsYear = $request->input('analytics_year', now()->year);
#         $analyticsMonth = $request->input('analytics_month', 'all');
#         $analyticsCategoryId = $request->input('analytics_category_id', 'all');
# 
#         $clicksQuery = DB::table('analytics_events')->whereYear('analytics_events.created_at', $analyticsYear);
# 
#         if ($analyticsMonth && $analyticsMonth !== 'all') {
#             $clicksQuery->whereMonth('analytics_events.created_at', $analyticsMonth);
#         }
# 
#         if ($analyticsCategoryId && $analyticsCategoryId !== 'all') {
#             $clicksQuery->where('analytics_events.category_id', $analyticsCategoryId);
#         }
# 
#         $clicksHistory = $clicksQuery
#             ->select('label', DB::raw('count(*) as total'))
#             ->groupBy('label')
#             ->orderByDesc('total')
#             ->orderBy('label', 'asc')
#             ->get();
# 
#         $dbYears = DB::table('analytics_events')
#             ->select(DB::raw('YEAR(created_at) as year'))
#             ->distinct()
#             ->pluck('year');
# 
#         $availableAnalyticsYears = $dbYears->push(now()->year)->unique()->sortDesc()->take(10)->values();
#         $availableAnalyticsCategories = Category::orderBy('name')->get(['id', 'name']);
#         $totalClicksToday = DB::table('analytics_events')->whereDate('created_at', Carbon::today())->count();
# 
#         // --- VISITOR-DATEN ---
#         $activeVisitors = DB::table('visits')
#             ->where('visited_at', '>=', now()->subMinutes(5))
#             ->distinct('visitor_id')
#             ->count('visitor_id');
# 
#         $visitorYear = $request->input('visitor_year', now()->year);
#         $visitorMonth = $request->input('visitor_month', 'all');
#         $visitorDeviceType = $request->input('visitor_device_type', 'all');
# 
#         $visitsQuery = DB::table('visits')->whereYear('visited_at', $visitorYear);
# 
#         if ($visitorMonth && $visitorMonth !== 'all') {
#             $visitsQuery->whereMonth('visited_at', $visitorMonth);
#         }
# 
#         if ($visitorDeviceType && $visitorDeviceType !== 'all') {
#             $visitsQuery->where('device_type', $visitorDeviceType);
#         }
# 
#         $visitsHistoryRaw = $visitsQuery
#             ->select(
#                 DB::raw('DATE(visited_at) as date'),
#                 'device_type',
#                 DB::raw('count(distinct visitor_id) as unique_visitors')
#             )
#             ->groupBy('date', 'device_type')
#             ->orderBy('date')
#             ->get();
# 
#         $visitsHistory = collect($visitsHistoryRaw)
#             ->groupBy('date')
#             ->map(function ($dayData, $date) {
#                 return [
#                     'date' => $date,
#                     'desktop' => $dayData->firstWhere('device_type', 'desktop')->unique_visitors ?? 0,
#                     'mobile' => $dayData->firstWhere('device_type', 'mobile')->unique_visitors ?? 0,
#                 ];
#             })
#             ->values();
# 
#         $dbVisitorYears = DB::table('visits')
#             ->select(DB::raw('YEAR(visited_at) as year'))
#             ->distinct()
#             ->pluck('year');
# 
#         $availableVisitorYears = $dbVisitorYears->push(now()->year)->unique()->sortDesc()->take(10)->values();
# 
#         return [
#             'stats' => [
#                 'totalConsents' => DB::table('consent_events')->count(),
#                 'analyticsAcceptanceRate' => DB::table('consent_events')->count() > 0
#                     ? round(
#                         (DB::table('consent_events')->where('analytics_given', true)->count() /
#                             DB::table('consent_events')->count()) * 100
#                     )
#                     : 0,
#             ],
#             'analyticsData' => [
#                 'history' => $clicksHistory,
#                 'availableYears' => $availableAnalyticsYears,
#                 'availableCategories' => $availableAnalyticsCategories,
#                 'totalToday' => $totalClicksToday,
#                 'filters' => [
#                     'year' => (int) $analyticsYear,
#                     'month' => $analyticsMonth === 'all' ? 'all' : (int) $analyticsMonth,
#                     'category_id' => $analyticsCategoryId === 'all' ? 'all' : (int) $analyticsCategoryId,
#                 ],
#             ],
#             'visitorData' => [
#                 'activeNow' => $activeVisitors,
#                 'history' => $visitsHistory,
#                 'availableYears' => $availableVisitorYears,
#                 'filters' => [
#                     'year' => (int) $visitorYear,
#                     'month' => $visitorMonth === 'all' ? 'all' : (int) $visitorMonth,
#                     'device_type' => $visitorDeviceType,
#                 ],
#             ],
#         ];
#     }
# 
#     // ===============================
#     // Generische statische Seiten
#     // ===============================
#     public function show(string $page): InertiaResponse
#     {
#         // Mapping für Slugs -> Vue-Komponenten
#         $map = [
#             'lebenslauf' => 'LifeHistory',
#             'kontakt' => 'Contactform',
#             'impressum' => 'Imprint',
#             'datenschutz' => 'Privacy',
#             'ueber-mich' => 'Aboutme', // URL "ueber-mich" → Komponente "Aboutme"
#             'dienstleistungen' => 'Services',
#             'projekte' => 'Projects',
#             'test' => 'Test',
#         ];
# 
#         $component = $map[$page] ?? ucfirst($page);
# 
#         return Inertia::render($component, [
#             'breadcrumbs' => [
#                 ['label' => 'Startseite', 'href' => route('welcome')],
#                 ['label' => ucfirst($page)],
#             ],
#         ]);
#     }
# }
