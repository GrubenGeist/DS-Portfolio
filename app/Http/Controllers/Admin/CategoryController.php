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
    public function index()
    {
        return Inertia::render('Admin/Users/Categories/Index', [
            'categories' => Category::orderBy('name')->get()->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'events_count' => DB::table('analytics_events')->where('category_id', $category->id)->count(),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        // NEU: Flash-Nachricht für Erfolg hinzufügen
        return redirect()->route('admin.categories.index')->with('success', 'Kategorie erfolgreich erstellt.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        $category->update($validated);

        // NEU: Flash-Nachricht für Erfolg hinzufügen
        return redirect()->route('admin.categories.index')->with('success', 'Kategorie erfolgreich aktualisiert.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        // NEU: Flash-Nachricht für Erfolg hinzufügen
        return redirect()->route('admin.categories.index')->with('success', 'Kategorie erfolgreich gelöscht.');
    }
}
