<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use App\Models\Role;
use App\Models\User; // HINZUGEFÜGT: Importieren Sie das Role Model
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;


class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
        {
            // 1. Validierung mit den NEUEN Feldern
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'company' => ['nullable', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                // Wir validieren, dass nur die erlaubten Rollen übergeben werden können
                'role' => ['required', 'string', Rule::in(['Admin', 'Company'])],
            ]);
        
            // 2. Benutzer mit den NEUEN Feldern erstellen
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company' => $request->company,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        
            // 3. Dem neuen Benutzer die Rolle mit der SPATIE-Methode zuweisen
            $user->assignRole($request->role);
        
            event(new Registered($user));
        
            // Wir leiten den Admin zurück zum Dashboard (oder einer Benutzerliste)
            // mit einer Erfolgsmeldung.
            return redirect(RouteServiceProvider::HOME)->with('success', 'Benutzer erfolgreich erstellt.');
        }
}
