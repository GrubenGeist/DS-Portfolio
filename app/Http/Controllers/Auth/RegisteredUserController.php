<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // HINZUGEFÜGT: Importieren Sie das Role Model
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:gast,betrieb,admin'], // HINZUGEFÜGT: Validierung der Rolle
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // HINZUGEFÜGT: Holen Sie die Rolle anhand des Slugs
        $role = Role::where('slug', $request->role)->firstOrFail();

        // HINZUGEFÜGT: Weisen Sie die Rolle dem Benutzer zu
        $user->role()->associate($role);
        $user->save(); // HINZUGEFÜGT: Speichern Sie den Benutzer mit der Rolle

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
}