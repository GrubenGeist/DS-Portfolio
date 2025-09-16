<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $query = User::query()->with('roles:name');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$searchTerm}%")
                    ->orWhere('company', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('role') && $request->input('role') !== 'all') {
            $roleName = $request->input('role');
            $query->whereHas('roles', fn($q) => $q->where('name', 'like', $roleName));
        }

        $users = $query->latest()
            ->paginate(15)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'name' => $user->name,
                'email' => $user->email,
                'company' => $user->company,
                'avatar' => $user->avatar,
                'roles' => $user->roles->pluck('name')->all(),
                'created_at' => $user->created_at?->toIso8601String(),
            ]);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'role']),
        ]);
    }

    public function editRole(User $user): Response
    {
        $roles = Role::all();

        return Inertia::render('Admin/Users/EditRole', [
            'user' => $user->load('roles'),
            'roles' => $roles,
        ]);
    }

    public function indexApi(Request $request): JsonResponse
    {
        try {
            $users = User::with('roles')->get();
            return response()->json($users);
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

        return redirect()->route('admin.users.index')->with('success', 'Rolle erfolgreich aktualisiert.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Sie können sich nicht selbst löschen.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Benutzer erfolgreich gelöscht.');
    }
}
