<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(): Response
    {
        $users = User::with('role')->get(); // Laden Sie die Rolle jedes Benutzers
        return Inertia::render('Admin/Users/Index', ['users' => $users]);
    }

    /**
     * Show the form for editing the specified user's role.
     */
    public function editRole(User $user): Response
    {
        $roles = Role::all();
        return Inertia::render('Admin/Users/EditRole', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the role of the specified user.
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'string', 'in:admin,betrieb,gast'], // Validierung der Rolle
        ]);

        $role = Role::where('slug', $request->role)->firstOrFail();
        $user->role()->associate($role);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Rolle erfolgreich aktualisiert.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Benutzer erfolgreich gelöscht.');
    }
}