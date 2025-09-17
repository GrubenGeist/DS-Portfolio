<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visit;
use Carbon\Carbon;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Erstellt zufällige Besucher-Einträge für die letzten 30 Tage.
     */
    public function run(): void
    {
        // Tabelle leeren, um doppelte Einträge zu vermeiden
        Visit::truncate();

        // Erstelle 2500 zufällige Besuche
        for ($i = 0; $i < 2500; $i++) {
            $ip = '192.168.1.' . rand(1, 254);
            $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36';

            // Zeitpunkt des Besuchs in den letzten 30 Tagen
            $visitedAt = Carbon::now()
                ->subDays(rand(0, 29))
                ->subMinutes(rand(0, 1440));

            Visit::create([
                'ip_address_hash' => sha1($ip),
                'user_agent_hash' => sha1($userAgent . $i),
                'device_type'     => rand(0, 10) > 3 ? 'desktop' : 'mobile',
                'last_seen'       => $visitedAt,  // ✅ für aktive Besucher relevant
                'created_at'      => $visitedAt,
                'updated_at'      => $visitedAt,
            ]);
        }

        // Einen „gerade aktiven“ Besucher hinzufügen
        Visit::create([
            'ip_address_hash' => sha1('127.0.0.1'),
            'user_agent_hash' => sha1('SeederTestAgent'),
            'device_type'     => 'desktop',
            'last_seen'       => now(),  // ✅ taucht sofort im Dashboard auf
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
