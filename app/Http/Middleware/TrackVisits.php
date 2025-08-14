<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // KORREKTUR: Die gesamte Logik wird nur ausgeführt, wenn der Nutzer bereits zugestimmt hat,
        // was durch die Existenz des 'laravel_consent'-Cookies signalisiert wird.
        if ($request->hasCookie('laravel_consent')) {
            // Wir tracken nur normale GET-Anfragen, die keine AJAX-Calls sind,
            // um das Tracking auf echte Seitenbesuche zu beschränken.
            if ($request->isMethod('get') && !$request->ajax()) {
                // Hole die eindeutige Besucher-ID aus der Session oder erstelle eine neue,
                // um den Besucher über mehrere Seitenaufrufe hinweg zu erkennen.
                $visitorId = $request->session()->get('visitor_id');
                if (!$visitorId) {
                    $visitorId = (string) Str::uuid();
                    $request->session()->put('visitor_id', $visitorId);
                }

                // =============================================================================
                // Logik zur Geräteerkennung
                // =============================================================================
                $userAgent = strtolower($request->header('User-Agent', ''));
                $deviceType = 'desktop'; // Standardwert ist 'desktop'

                // Einfache Prüfung, ob typische mobile Schlüsselwörter im User-Agent enthalten sind.
                $mobileKeywords = ['mobile', 'android', 'iphone', 'ipod', 'blackberry', 'windows phone'];
                foreach ($mobileKeywords as $keyword) {
                    if (str_contains($userAgent, $keyword)) {
                        $deviceType = 'mobile';
                        break; // Schleife beenden, sobald ein Treffer gefunden wurde
                    }
                }

                // Speichere den Besuch in der Datenbank mit der Besucher-ID und dem Gerätetyp.
                DB::table('visits')->insert([
                    'visitor_id' => $visitorId,
                    'device_type' => $deviceType, // Die neue Spalte wird hier gefüllt
                    'visited_at' => now(),
                ]);
            }
        }

        return $next($request);
    }
}
