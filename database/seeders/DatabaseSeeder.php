<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
           // SeedAnalyticsEvents::class,
           // VisitSeeder::class,
           // VisitsTableSeeder::class
           // VisitTableSeeder_UserAgents::class

        ]);
    }
}

