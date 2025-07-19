<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        // Wir tracken nur normale GET-Anfragen, keine API-Calls oder Formular-Absendungen
        if ($request->isMethod('get') && !$request->ajax()) {
            // Wir nutzen die Session-ID von Laravel als anonyme Besucher-ID
            $visitorId = $request->session()->getId();

            DB::table('visits')->insert([
                'visitor_id' => $visitorId,
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
