<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeedAnalyticsEvents extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Kategorien erstellen und IDs merken
        $category1 = DB::table('categories')->insertGetId([
            'name' => 'Test-Kategorie A',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $category2 = DB::table('categories')->insertGetId([
            'name' => 'Test-Kategorie B',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Events einfügen mit gültigen category_id
        DB::table('analytics_events')->insert([
            [
                'label' => 'Test-Ereignis A',
                'category_id' => $category1,
                'action' => 'click',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'label' => 'Test-Ereignis B',
                'category_id' => $category2,
                'action' => 'click',
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],
            [
                'label' => 'Test-Ereignis C',
                'category_id' => $category1,
                'action' => 'click',
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
        ]);
    }
}
