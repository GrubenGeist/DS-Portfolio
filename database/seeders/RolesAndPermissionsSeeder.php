<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash; // Nötig, wenn du einen Standard-Admin erstellst
use App\Models\User; // Nötig, wenn du einen Standard-Admin erstellst

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        //Cache leeren
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Permissions erstellen
        $createUserPermission = Permission::create(['name' => 'create user']);
        
        // Optionale, spezifischere Permission für Company-Inhalte
        $viewCompanyContentPermission = Permission::create(['name' => 'view company content']);
        // Füge hier ggf. weitere Permissions hinzu, z.B. für Posts, wenn benötigt
        // $createPostPermission = Permission::create(['name' => 'create post']);
        // $editPostPermission = Permission::create(['name' => 'edit post']);
        // $deletePostPermission = Permission::create(['name' => 'delete post']);

        //Rollen erstellen
        $companyRole = Role::create(['name' => 'Company']); // Rolle für Unternehmen/Kunden
        $adminRole = Role::create(['name' => 'Admin']);     // Admin-Rolle

        //Permissions an Rollen zuweisen (optional für Admin wegen Gate::before)

        //Company darf spezifische Inhalte sehen (optional, wenn auch über Route-Middleware gesteuert)
        $companyRole->givePermissionTo($viewCompanyContentPermission);
        //$companyRole->givePermissionTo($createPostPermission); // Beispiel: Wenn Company Posts erstellen darf

        // Admin: Dank Gate::before muss hier nichts zugewiesen werden.
        // Zur Klarheit KANN man es trotzdem tun, wenn man möchte:
        $adminRole->givePermissionTo($createUserPermission);
        $adminRole->givePermissionTo($viewCompanyContentPermission);
        // $adminRole->givePermissionTo($createPostPermission);
        // $adminRole->givePermissionTo($editPostPermission);
        // $adminRole->givePermissionTo($deletePostPermission);
        // ...alle anderen Permissions...

        //Optional: Einen Standard-Admin-Benutzer erstellen
        // Nützlich, damit du dich direkt als Admin einloggen kannst
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'ds-it-admin@example.com',
            'password' => Hash::make('ds-it-admin-pw1'),
        ]);
        $adminUser->assignRole($adminRole);

        // Optional: Einen Standard-Company-Benutzer erstellen
        $companyUser = User::factory()->create([
            'name' => 'Test Company',
            'email' => 'company@example.com',
            'password' => Hash::make('CompanyPW'),
        ]);
        $companyUser->assignRole($companyRole);

    }
}