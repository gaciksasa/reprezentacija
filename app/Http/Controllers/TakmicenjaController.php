<?php

namespace App\Http\Controllers;

use App\Models\Takmicenje;
use Illuminate\Http\Request;

class TakmicenjaController extends Controller
{
    /**
     * Prikaz svih takmičenja.
     */
    public function index()
    {
        $takmicenja = Takmicenje::orderBy('naziv')->get();
        return view('takmicenja.index', compact('takmicenja'));
    }

    /**
     * Prikaz forme za kreiranje takmičenja.
     */
    public function create()
    {
        return view('takmicenja.create');
    }

    /**
     * Čuvanje novog takmičenja.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'sezona' => 'nullable|string|max:50',
            'organizator' => 'nullable|string|max:255',
        ]);

        Takmicenje::create($validated);

        return redirect()->route('takmicenja.index')
            ->with('success', 'Takmičenje uspešno kreirano.');
    }

    /**
     * Prikaz pojedinačnog takmičenja.
     */
    public function show(Takmicenje $takmicenje)
    {
        $utakmice = $takmicenje->utakmice()
            ->with(['domacin', 'gost'])
            ->orderBy('datum', 'desc')
            ->get();
            
        return view('takmicenja.show', compact('takmicenje', 'utakmice'));
    }

    /**
     * Prikaz forme za izmenu takmičenja.
     */
    public function edit(Takmicenje $takmicenje)
    {
        return view('takmicenja.edit', compact('takmicenje'));
    }

    /**
     * Ažuriranje takmičenja.
     */
    public function update(Request $request, Takmicenje $takmicenje)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'sezona' => 'nullable|string|max:50',
            'organizator' => 'nullable|string|max:255',
        ]);

        $takmicenje->update($validated);

        return redirect()->route('takmicenja.index')
            ->with('success', 'Takmičenje uspešno ažurirano.');
    }

    /**
     * Brisanje takmičenja.
     */
    public function destroy(Takmicenje $takmicenje)
    {
        try {
            $takmicenje->delete();
            return redirect()->route('takmicenja.index')
                ->with('success', 'Takmičenje uspešno obrisano.');
        } catch (\Exception $e) {
            return redirect()->route('takmicenja.index')
                ->with('error', 'Takmičenje nije moguće obrisati jer se koristi u drugim tabelama.');
        }
    }
}