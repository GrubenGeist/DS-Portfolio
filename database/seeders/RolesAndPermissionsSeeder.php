<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Cache leeren
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions erstellen (nur wenn sie nicht existieren)
        $createUserPermission = Permission::firstOrCreate(['name' => 'create user']);
        $viewCompanyContentPermission = Permission::firstOrCreate(['name' => 'view company content']);
        $viewCustomerContentPermission = Permission::firstOrCreate(['name' => 'view customer content']);

        // Rollen erstellen (nur wenn sie nicht existieren)
        $companyRole = Role::firstOrCreate(['name' => 'Company']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $customerRole = Role::firstOrCreate(['name' => 'Customer']);

        // Permissions an Rollen zuweisen
        $companyRole->givePermissionTo($viewCompanyContentPermission);
        $customerRole->givePermissionTo($viewCustomerContentPermission);
        $adminRole->givePermissionTo($createUserPermission);
        $adminRole->givePermissionTo($viewCompanyContentPermission);

        // Standard-Benutzer erstellen mit den korrekten Spalten
        $adminUser = User::firstOrCreate(
            ['email' => 'ds-it-admin@example.com'],
            [
                'first_name' => 'Admin', // Geändert von 'name'
                'last_name' => 'User',   // Hinzugefügt
                'password' => Hash::make('ds-it-admin-pw1'),
            ]
        );
        $adminUser->assignRole($adminRole);

        $companyUser = User::firstOrCreate(
            ['email' => 'company@example.com'],
            [
                'first_name' => 'Test',      // Geändert von 'name'
                'last_name' => 'Company',    // Hinzugefügt
                'password' => Hash::make('CompanyPW'),
            ]
        );
        $companyUser->assignRole($companyRole);

        $customerUser = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'first_name' => 'Test',      // Geändert von 'name'
                'last_name' => 'Kunde',      // Hinzugefügt
                'password' => Hash::make('CustomerPW'),
            ]
        );
        $customerUser->assignRole($customerRole);
    }
}