<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Dein User-Model
use Illuminate\Support\Facades\Hash; // Zum Verschlüsseln des Passworts

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Erstelle den Admin-Benutzer nur, wenn er noch nicht existiert
        $adminUser = User::firstOrCreate(
            ['email' => 'dennis-strauss@web.de'], // Eindeutiges Feld zum Suchen
            [
                'first_name' => 'ADMIN',
                'last_name' => 'ADMIN',
                'password' => Hash::make('password'), // Setze hier ein sicheres Standardpasswort
                'email_verified_at' => now(), // Verifiziert die E-Mail sofort
            ]
        );

        // Weise dem Benutzer die 'Admin'-Rolle zu
        $adminUser->assignRole('Admin');
    }
}