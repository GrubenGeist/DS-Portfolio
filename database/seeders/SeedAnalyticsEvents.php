<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category; // WICHTIG: Das Category-Model importieren

class SeedAnalyticsEvents extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dieser Seeder wurde verwendet, um die Datenbank während der Entwicklung mit
        // Testdaten für die Klick-Analyse zu füllen. Für den Live-Betrieb ist er
        // nicht notwendig, kann aber für Testzwecke beibehalten werden.
        // Wenn Sie keine automatischen Testdaten benötigen, kann diese Methode leer bleiben.

        /*
        $eventsData = [
            'Test-Kategorie A' => ['Test-Ereignis A', 'Test-Ereignis B'],
            'Test-Kategorie B' => ['Test-Ereignis C', 'Test-Ereignis A'],
            'Footer Links' => ['Impressum Klick', 'Datenschutz Klick'],
        ];

        foreach ($eventsData as $categoryName => $labels) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($labels as $label) {
                for ($i = 0; $i < rand(1, 5); $i++) {
                    DB::table('analytics_events')->insert([
                        'action' => 'click',
                        'label' => $label,
                        'category_id' => $category->id,
                        'created_at' => now()->subDays(rand(0, 365)),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        */
    }
}
