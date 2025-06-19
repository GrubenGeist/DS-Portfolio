<?php

namespace App\Http\Controllers;

use App\Models\User; // **WICHTIG: User-Model importieren**
use Illuminate\Support\Facades\Log; // **WICHTIG: Log-Fassade importieren**
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse; // Für route() in Breadcrumbs

class PageController extends Controller
{
    public function welcome(): InertiaResponse
    {
        return Inertia::render('Welcome', [
            'breadcrumbs' => [['label' => 'Startseite', 'href' => route('welcome')]], // Vom Backend
        ]);
    }

    public function contactForm(): InertiaResponse
    {
        return Inertia::render('Contactform', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Kontaktformular'],
            ],
        ]);
    }

    public function dashboard(): InertiaResponse // Für Admin-Dashboard
    {
        $usersForDashboard = [];
        $errorLoadingUsers = null;

        try {
            // Lade die Benutzerdaten direkt hier. Diese Logik ist ähnlich
            // zu der, die du in Admin\UserController@indexApi hattest.
            // Stelle sicher, dass die User-Daten so formatiert sind,
            // wie Dashboard.vue sie in der 'initialUsers'-Prop erwartet.
            $usersForDashboard = User::with('roles')->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->map(fn ($role) => ['name' => $role->name])->all(),
                    // Füge hier weitere benötigte Felder hinzu, die Dashboard.vue direkt braucht
                ];
            })->all();
        } catch (\Exception $e) {
            Log::error('Fehler beim Laden der Benutzer für das Dashboard im PageController: '.$e->getMessage());
            $errorLoadingUsers = 'Benutzerdaten konnten nicht initial geladen werden.';
        }

        return Inertia::render('Dashboard', [
            'breadcrumbs' => [['label' => 'Dashboard', 'href' => route('dashboard')]], // 'href' für Konsistenz hinzugefügt
            'initialUsers' => $usersForDashboard,      // **Benutzerdaten als Prop übergeben**
            'userFetchError' => $errorLoadingUsers,  // **Eventuelle Fehlermeldung übergeben**
        ]);
    }

    public function showAdminRegistrationForm(): InertiaResponse
    {
        return Inertia::render('register', [ // Stelle sicher, dass 'register.vue' existiert
            'breadcrumbs' => [['label' => 'Benutzer registrieren (Admin)']],
        ]);
    }

    public function testPage(): InertiaResponse
    {
        return Inertia::render('Test', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Testseite'],
            ],
        ]);
    }

    public function projects(): InertiaResponse
    {
        return Inertia::render('Projects', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Projekte'],
            ],
        ]);
    }

    public function services(): InertiaResponse
    {
        return Inertia::render('Services', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Dienstleistungen'],
            ],
        ]);
    }

    public function aboutMe(): InertiaResponse
    {
        return Inertia::render('Aboutme', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Über Mich'],
            ],
        ]);
    }
}
