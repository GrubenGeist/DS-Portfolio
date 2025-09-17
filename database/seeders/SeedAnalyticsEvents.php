<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeedAnalyticsEvents extends Seeder
{
    /**
     * Run the database seeds.
     * * Erstellt zufällige Analytics-Events für die letzten 30 Tage.
     */
    public function run(): void
    {
        // Leere die Tabelle, um bei jedem Seed saubere Daten zu haben.
        DB::table('analytics_events')->truncate();

        $actions = ['button_click', 'link_click', 'image_click'];
        $labels = ['hero-cta', 'contact-submit', 'project-card-1', 'footer-imprint', 'nav-projects'];

        // Erstelle 150 zufällige Events.
        for ($i = 0; $i < 150; $i++) {
            DB::table('analytics_events')->insert([
                'action' => $actions[array_rand($actions)],
                'label' => $labels[array_rand($labels)],
                'created_at' => Carbon::now()->subDays(rand(0, 30))->subMinutes(rand(0, 1440)),
                'updated_at' => now(),
            ]);
        }
    }
}