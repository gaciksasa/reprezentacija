<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::with('parent')->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $parentCategories = Category::orderBy('name')->get();
        return view('categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Generate slug from name
        $slug = Str::slug($validated['name']);
        
        // Check if the slug already exists
        $count = Category::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }
        
        // Add slug to validated data
        $validated['slug'] = $slug;
        
        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategorija uspešno kreirana.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'posts']);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();
        return view('categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Generate slug from name only if name changed
        if ($category->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            
            // Check if the slug already exists
            $count = Category::where('slug', 'like', $slug . '%')
                ->where('id', '!=', $category->id)
                ->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            
            // Add slug to validated data
            $validated['slug'] = $slug;
        }
        
        // Prevent circular references in parent-child relationships
        if ($validated['parent_id'] == $category->id) {
            return back()->withErrors(['parent_id' => 'Kategorija ne može biti sopstveni roditelj.']);
        }
        
        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategorija uspešno ažurirana.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has children
        if ($category->children()->count() > 0) {
            return back()->withErrors(['delete' => 'Ne možete obrisati kategoriju koja ima podkategorije.']);
        }
        
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Kategorija uspešno obrisana.');
    }
}