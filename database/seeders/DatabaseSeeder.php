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
        // Rufe unsere neuen Seeder in der richtigen Reihenfolge auf:
        // Zuerst die Rollen erstellen, dann den Benutzer, der die Rolle braucht.
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}