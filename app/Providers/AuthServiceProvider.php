<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate; // Wird unten explizit importiert
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // Import für die Gate-Fassade
use Illuminate\Support\Facades\Log;  // Import für die Log-Fassade (zum Debuggen)

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Hier registrierst du deine Model Policies, falls du welche hast
        // z.B. 'App\Models\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Diese Zeile registriert die oben definierten Policies (falls vorhanden)
        // $this->registerPolicies(); // Kann auskommentiert bleiben, wenn keine Policies definiert sind

        // --- HIER kommt die Logik für den "Super-Admin" ---

        // Debugging-Log: Prüfen, ob die boot()-Methode überhaupt aufgerufen wird
        Log::info('AuthServiceProvider boot method called.');

        // Definiert die Gate::before Regel
        Gate::before(function ($user, $ability) {
            // Debugging-Log: Prüfen, ob die Closure erreicht wird
            Log::info('Gate::before check running for user ID: '.$user->id);

            // Prüft, ob der Benutzer die Rolle 'Admin' hat (achte auf Groß/Kleinschreibung!)
            $isAdmin = $user->hasRole('Admin');

            // Debugging-Log: Was ist das Ergebnis der Rollenprüfung?
            Log::info('User ID '.$user->id.' has Admin role? '.($isAdmin ? 'Yes' : 'No'));

            // Wenn $isAdmin true ist, gib true zurück (Zugriff erlaubt, weitere Checks übersprungen)
            // Wenn $isAdmin false ist, gib null zurück (normale Checks laufen weiter)
            return $isAdmin ? true : null;
        });

        // Debugging-Log: Bestätigen, dass die Closure registriert wurde
        Log::info('Gate::before closure registered.');

        // --- Ende der Super-Admin Logik ---

        // Hier könnten noch andere Gate-Definitionen stehen (z.B. Gate::define(...))
    }
}
