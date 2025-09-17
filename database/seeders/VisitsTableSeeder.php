<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visit;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VisitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tabelle leeren, damit die Seeds konsistent sind
        Visit::truncate();

        // Wir simulieren 10 verschiedene Besucher
        for ($i = 0; $i < 10; $i++) {
            $isMobile = (bool) random_int(0, 1);

            Visit::create([
                'ip_address_hash' => sha1("192.168.0.$i"),
                'user_agent_hash' => sha1(Str::random(20)),
                'device_type'     => $isMobile ? 'mobile' : 'desktop',
                'last_seen'       => Carbon::now()->subMinutes(random_int(0, 20)),
            ]);
        }

        // Einen "aktiven" Besucher für dein Dashboard simulieren
        Visit::create([
            'ip_address_hash' => sha1("127.0.0.1"),
            'user_agent_hash' => sha1('TestAgent'),
            'device_type'     => 'desktop',
            'last_seen'       => now(),
        ]);
    }
}
