<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request; // Dieser Import ist schon korrekt vorhanden
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    // KORRIGIERTE INDEX-METHODE
    public function index(Request $request): Response // <-- KORREKTUR 1: Request $request hier übergeben
    {
        // 1. Wir starten mit dem Query Builder.
        $query = User::query();
        
        // 2. Filterung nach dem Suchbegriff.
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$searchTerm}%")
                    ->orWhere('company', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
    
        // 3. Filterung nach der Rolle.
        if ($request->filled('role') && $request->input('role') !== 'all') {
            $roleName = $request->input('role');
            // whereHas ist die Spatie-Methode, um nach Relationen zu filtern
            $query->whereHas('roles', fn ($q) => $q->where('name', $roleName));
        }
    
        // 4. Führe die Abfrage aus und lade die Rollen-Beziehung.
        $users = $query->with('roles')->get();
    
        // 5. Gib die Daten und die benutzten Filter an das Frontend zurück.
        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'role']),
        ]);
        
        // KORREKTUR 2: Der doppelte Codeblock von hier bis zum Ende der Methode wurde entfernt.
    }

    // Die restlichen Methoden (editRole, updateRole, etc.) bleiben unverändert.
    public function editRole(User $user): Response
    {
        // 1. Lade alle existierenden Rollen aus der Datenbank.
    // Stellt sicher, dass das Role-Model von Spatie importiert ist: use Spatie\Permission\Models\Role;
    $roles = Role::all();

    // 2. Rendere die Vue-Komponente und übergib ihr die notwendigen Daten.
    return Inertia::render('Admin/Users/EditRole', [
        // Wir übergeben den spezifischen Benutzer, der bearbeitet wird...
        // .load('roles') ist eine gute Praxis, um sicherzustellen, dass die Rollen des Benutzers frisch geladen sind.
        'user' => $user->load('roles'),
        
        // ...und die Liste aller verfügbaren Rollen für das Dropdown-Menü.
        'roles' => $roles,
    ]);
    }

    public function indexApi(Request $request): JsonResponse
    {
        try {
            // Die Logik ist hier fast identisch zur normalen index-Methode.
            // Wir holen alle Benutzer inklusive ihrer Rollen.
            $users = User::with('roles')->get();
    
            // Wir geben die Benutzer als JSON-Antwort zurück.
            return response()->json($users);
            
        } catch (\Exception $e) {
            // Dein Error-Handling ist schon perfekt.
            Log::error('API /api/users Error: '.$e->getMessage().' Stack: '.$e->getTraceAsString());
            return response()->json(['message' => 'Fehler beim Abrufen der Benutzerdaten.'], 500);
        }
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        // 1. Validiere die ankommenden Daten. Wir stellen sicher, dass die übergebene Rolle
        // auch wirklich in unserer 'roles'-Datenbanktabelle existiert.
        $validated = $request->validate([
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name'), // Rule::exists ist sehr wichtig für die Sicherheit
            ],
        ]);
    
        // 2. Weist dem Benutzer die neue Rolle zu.
        // syncRoles ist die empfohlene Spatie-Methode: Sie entfernt alle alten Rollen
        // des Benutzers und fügt nur die eine neue hinzu. Das verhindert Fehler.
        $user->syncRoles([$validated['role']]);
    
        // 3. Leite den Admin zurück zur Benutzerliste mit einer Erfolgsmeldung.
        // Wichtig: Wir verwenden den korrekten Routen-Namen 'admin.users.index',
        // den wir zuvor für die Admin-Routen festgelegt haben.
        return redirect()->route('admin.users.index')->with('success', 'Rolle erfolgreich aktualisiert.');
    }

    public function destroy(User $user): RedirectResponse
    {
        // Sicherheitsabfrage: Verhindert, dass der eingeloggte Admin sich selbst löscht.
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Sie können sich nicht selbst löschen.');
        }
    
        $user->delete();
    
        return redirect()->route('admin.users.index')->with('success', 'Benutzer erfolgreich gelöscht.');
    }
}