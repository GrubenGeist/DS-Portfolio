<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role; // Korrekter Import
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule; // Korrekter Import
use Inertia\Inertia;
use Inertia\Response;

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
            'roles' => $roles
        ]);
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')
            ]
        ]);
        $user->syncRoles([$validated['role']]);
        return redirect()->route('admin.users.index')->with('success', 'Rolle erfolgreich aktualisiert.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Benutzer erfolgreich gelöscht.');
    }
}