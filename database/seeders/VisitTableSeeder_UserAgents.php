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
     * Erstellt zufällige Besucher-Einträge mit realistischen UserAgents.
     */
    public function run(): void
    {
        // Tabelle leeren
        Visit::truncate();

        // Beispiel-UserAgents
        $desktopAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 14_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Safari/605.1.15',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:118.0) Gecko/20100101 Firefox/118.0',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edg/120.0.0.0',
        ];

        $mobileAgents = [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Linux; Android 14; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
            'Mozilla/5.0 (Linux; Android 13; SM-G991B) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/21.0 Chrome/120.0.0.0 Mobile Safari/537.36',
        ];

        // 50 zufällige Besucher erzeugen
        for ($i = 0; $i < 50; $i++) {
            $isMobile = rand(0, 10) > 3; // ca. 70% Mobile, 30% Desktop
            $userAgent = $isMobile
                ? $mobileAgents[array_rand($mobileAgents)]
                : $desktopAgents[array_rand($desktopAgents)];

            $ip = '192.168.' . rand(0, 255) . '.' . rand(1, 254);

            // Zeitpunkt des Besuchs in den letzten 30 Tagen
            $visitedAt = Carbon::now()
                ->subDays(rand(0, 29))
                ->subMinutes(rand(0, 1440));

            Visit::create([
                'ip_address_hash' => sha1($ip),
                'user_agent_hash' => sha1($userAgent . $i),
                'device_type'     => $isMobile ? 'mobile' : 'desktop',
                'last_seen'       => $visitedAt,
                'created_at'      => $visitedAt,
                'updated_at'      => $visitedAt,
            ]);
        }

        // Einen garantiert aktiven Besucher hinzufügen
        Visit::create([
            'ip_address_hash' => sha1('127.0.0.1'),
            'user_agent_hash' => sha1('SeederTestAgent'),
            'device_type'     => 'desktop',
            'last_seen'       => now(),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
