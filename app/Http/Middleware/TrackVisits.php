<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        // Admins nicht tracken
        if ($request->user() && $request->user()->hasRole('Admin')) {
            return $next($request);
        }

        // Gäste nur mit Consent
        if (!$request->hasCookie('laravel_consent') && !$request->user()) {
            return $next($request);
        }

        // Hashes erstellen
        $ipAddressHash = sha1($request->ip());
        $userAgent     = $request->userAgent() ?? '';
        $userAgentHash = sha1($userAgent);

        $deviceType = stripos($userAgent, 'mobile') !== false ? 'mobile' : 'desktop';

        // Besucher suchen
        $visit = Visit::query()
            ->where('ip_address_hash', $ipAddressHash)
            ->where('user_agent_hash', $userAgentHash)
            ->first();

        if ($visit) {
            // Nur updaten, wenn letzter Eintrag älter als 30 Sekunden
            if ($visit->last_seen === null || $visit->last_seen->lt(now()->subSeconds(30))) {
                $visit->update(['last_seen' => now()]);
            }
        } else {
            // Neuer Datensatz
            Visit::create([
                'ip_address_hash' => $ipAddressHash,
                'user_agent_hash' => $userAgentHash,
                'device_type'     => $deviceType,
                'last_seen'       => now(),
            ]);
        }

        return $next($request);
    }
}
