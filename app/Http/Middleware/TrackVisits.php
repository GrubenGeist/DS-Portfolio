<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Bedingung 1: Der Nutzer muss den Cookies zugestimmt haben.
        if ($request->hasCookie('laravel_consent')) {
            
            // Bedingung 2: Ich tracken jede GET-Anfrage, AUSSER der reinen Datenabfrage für das Dashboard.
            if ($request->isMethod('get') && !$request->routeIs('dashboard.data')) {

                // Bedingung 3: Ich tracken keine eingeloggten Admins, um die Statistik sauber zu halten.
                if (!Auth::check() || !Auth::user()->hasRole('Admin')) {
                
                    // =============================================================================
                    // Anonymisierter Besucher-Fingerabdruck
                    // =============================================================================
                    // Ich erstelle eine eindeutige, aber anonyme ID für den Besucher,
                    // indem ich seine IP-Adresse und seinen User-Agent hashen.
                    // Dieser Hash ist nicht auf die Person zurückführbar, aber beständig.
                    
                    $ipAddress = $request->ip();
                    $userAgent = $request->header('User-Agent', '');
                    
                    // Ein "Salt" fügt dem Hash zusätzliche Zufälligkeit hinzu.
                    // Ich verwenden den sicheren App-Key von Laravel.
                    $salt = config('app.key'); 
                    
                    $visitorId = hash('sha256', $ipAddress . $userAgent . $salt);

                    // Logik zur Geräteerkennung (bleibt unverändert)
                    $deviceType = 'desktop';
                    $mobileKeywords = ['mobile', 'android', 'iphone', 'ipod', 'blackberry', 'windows phone'];
                    foreach ($mobileKeywords as $keyword) {
                        if (str_contains(strtolower($userAgent), $keyword)) {
                            $deviceType = 'mobile';
                            break;
                        }
                    }

                    // Speichere den Besuch in der Datenbank.
                    DB::table('visits')->insert([
                        'visitor_id' => $visitorId,
                        'device_type' => $deviceType,
                        'visited_at' => now(),
                    ]);
                }
            }
        }

        return $next($request);
    }
}
