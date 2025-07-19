<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Zeigt eine Liste aller Kategorien an.
     */
    public function index()
    {
        // KORREKTUR: Der Pfad zur Vue-Komponente wurde an deine Ordnerstruktur angepasst.
        return Inertia::render('Admin/Users/Categories/Index', [
            'categories' => Category::orderBy('name')->get()->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'events_count' => DB::table('analytics_events')->where('category_id', $category->id)->count(),
            ]),
        ]);
    }

    /**
     * Speichert eine neu erstellte Kategorie.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Aktualisiert eine bestehende Kategorie.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Löscht eine Kategorie.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
