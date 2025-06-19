<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse; // Korrekter Import
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia; // Korrekter Import
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): Response
    {
        // Log::info('UserController@index called.'); // Debug log entfernt
        $users = User::with('roles')->get();

        // Log::info('Users fetched count: ' . $users->count()); // Debug log entfernt
        return Inertia::render('Admin/Users/Index', ['users' => $users]);
    }

    public function editRole(User $user): Response
    {
        $roles = Role::all();

        return Inertia::render('Admin/Users/EditRole', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function indexApi(Request $request): JsonResponse
    {
        try {
            // Hole die Benutzerdaten, eventuell mit Paginierung für eine API
            $users = User::with('roles')->get(); // oder User::paginate(15);

            return response()->json($users); // Gib die Benutzer als JSON zurück
        } catch (\Exception $e) {
            Log::error('API /api/users Error: '.$e->getMessage().' Stack: '.$e->getTraceAsString());

            return response()->json(['message' => 'Fehler beim Abrufen der Benutzerdaten.'], 500);
        }
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name'),
            ],
        ]);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('settings.users.index')->with('success', 'Rolle erfolgreich aktualisiert.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('settings.users.index')->with('success', 'Benutzer erfolgreich gelöscht.');
    }
}
