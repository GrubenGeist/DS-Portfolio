<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Category;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Diese __invoke Methode MUSS exakt so heißen.
     * Nicht 'index', nicht '_invoke', sondern '__invoke'.
     */
    public function __invoke(Request $request): Response
    {
        // ... (Der Rest des Codes, der bereits funktionierte)
        $visitDataHistory = Visit::query()
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw("SUM(CASE WHEN device_type = 'desktop' THEN 1 ELSE 0 END) as desktop"),
                DB::raw("SUM(CASE WHEN device_type = 'mobile' THEN 1 ELSE 0 END) as mobile"),
            ])
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get() ?? collect();

        $eventDataHistory = AnalyticsEvent::query()
            ->select('label', DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('label')
            ->orderBy('total', 'desc')
            ->get() ?? collect();
            
        $availableYears = Visit::query()->select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year', 'desc')->pluck('year');
        $activeNow = Visit::query()->where('created_at', '>=', now()->subMinutes(5))->count();
        $totalToday = AnalyticsEvent::query()->whereDate('created_at', today())->count();
        $availableCategories = Category::query()->select('id', 'name')->get();

        return Inertia::render('Dashboard', [
            'visitData' => [
                'history' => $visitDataHistory,
                'availableYears' => $availableYears,
                'activeNow' => $activeNow,
                'filters' => [], 
            ],
            'eventData' => [
                'history' => $eventDataHistory,
                'totalToday' => $totalToday,
                'availableCategories' => $availableCategories,
                'availableYears' => $availableYears,
                'filters' => [],
            ],
        ]);
    }
}