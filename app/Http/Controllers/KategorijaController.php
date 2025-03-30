<?php

namespace App\Http\Controllers;

use App\Models\Kategorija;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategorijaController extends Controller
{
    /**
     * Display a listing of the kategorije.
     */
    public function index()
    {
        $kategorije = Kategorija::with('parent')->orderBy('name')->get();
        return view('kategorije.index', compact('kategorije'));
    }

    /**
     * Show the form for creating a new Kategorija.
     */
    public function create()
    {
        $parentKategorije = Kategorija::orderBy('name')->get();
        return view('kategorije.create', compact('parentKategorije'));
    }

    /**
     * Store a newly created Kategorija in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:kategorije,id',
        ]);

        // Generate slug from name
        $slug = Str::slug($validated['name']);
        
        // Check if the slug already exists
        $count = Kategorija::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }
        
        // Add slug to validated data
        $validated['slug'] = $slug;
        
        Kategorija::create($validated);

        return redirect()->route('kategorije.index')
            ->with('success', 'Kategorija uspešno kreirana.');
    }

    /**
     * Display the specified Kategorija.
     */
    public function show(Kategorija $kategorije)
    {
        // Promenjeno iz $kategorija u $kategorije da odgovara parametru rute
        $kategorija = $kategorije; // Preimenovanje varijable za konzistentnost u pogledu
        
        // Eager load parent, children and posts with their authors
        $kategorija->load([
            'parent',
            'children',
            'posts' => function($query) {
                $query->orderBy('post_date', 'desc');
            }
        ]);
        
        return view('kategorije.show', compact('kategorija'));
    }

    /**
     * Show the form for editing the specified Kategorija.
     */
    public function edit(Kategorija $kategorije)
    {
        // Promenjeno iz $kategorija u $kategorije da odgovara parametru rute
        $kategorija = $kategorije; // Preimenovanje varijable za konzistentnost u pogledu
        
        $parentKategorije = Kategorija::where('id', '!=', $kategorija->id)
            ->orderBy('name')
            ->get();
        return view('kategorije.edit', compact('kategorija', 'parentKategorije'));
    }

    /**
     * Update the specified Kategorija in storage.
     */
    public function update(Request $request, Kategorija $kategorije)
    {
        // Promenjeno iz $kategorija u $kategorije da odgovara parametru rute
        $kategorija = $kategorije; // Preimenovanje varijable za konzistentnost u pogledu
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:kategorije,id',
        ]);

        // Generate slug from name only if name changed
        if ($kategorija->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            
            // Check if the slug already exists
            $count = Kategorija::where('slug', 'like', $slug . '%')
                ->where('id', '!=', $kategorija->id)
                ->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            
            // Add slug to validated data
            $validated['slug'] = $slug;
        }
        
        // Prevent circular references in parent-child relationships
        if (isset($validated['parent_id']) && $validated['parent_id'] == $kategorija->id) {
            return back()->withErrors(['parent_id' => 'Kategorija ne može biti sopstveni roditelj.']);
        }
        
        $kategorija->update($validated);

        return redirect()->route('kategorije.index')
            ->with('success', 'Kategorija uspešno ažurirana.');
    }

    /**
     * Remove the specified Kategorija from storage.
     */
    public function destroy(Kategorija $kategorije)
    {
        // Promenjeno iz $kategorija u $kategorije da odgovara parametru rute
        $kategorija = $kategorije; // Preimenovanje varijable za konzistentnost u pogledu
        
        // Check if Kategorija has children
        if ($kategorija->children()->count() > 0) {
            return back()->withErrors(['delete' => 'Ne možete obrisati kategoriju koja ima podkategorije.']);
        }
        
        $kategorija->delete();
        return redirect()->route('kategorije.index')
            ->with('success', 'Kategorija uspešno obrisana.');
    }
}