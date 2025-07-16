<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Wichtig: Spatie-Rolle importieren

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Erstelle die 'Admin'-Rolle, wenn sie noch nicht existiert
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        
        // Erstelle die 'Company'-Rolle, wenn sie noch nicht existiert
        Role::firstOrCreate(['name' => 'Company', 'guard_name' => 'web']);

                // Erstelle die 'Company'-Rolle, wenn sie noch nicht existiert
        Role::firstOrCreate(['name' => 'Customer', 'guard_name' => 'web']);
    }
}