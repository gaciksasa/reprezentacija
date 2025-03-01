<?php

namespace App\Http\Controllers;

use App\Models\Sudija;
use Illuminate\Http\Request;

class SudijeController extends Controller
{
    /**
     * Prikaz svih sudija.
     */
    public function index()
    {
        $sudije = Sudija::orderBy('prezime')->get();
        return view('sudije.index', compact('sudije'));
    }

    /**
     * Prikaz forme za kreiranje sudije.
     */
    public function create()
    {
        return view('sudije.create');
    }

    /**
     * Čuvanje nove sudije.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'nacionalnost' => 'required|string|max:100',
        ]);

        Sudija::create($validated);

        return redirect()->route('sudije.index')
            ->with('success', 'Sudija uspešno kreiran.');
    }

    /**
     * Prikaz pojedinačne sudije.
     */
    public function show(Sudija $sudija)
    {
        $utakmice = $sudija->utakmice()
            ->with(['domacin', 'gost', 'takmicenje'])
            ->orderBy('datum', 'desc')
            ->get();
            
        return view('sudije.show', compact('sudija', 'utakmice'));
    }

    /**
     * Prikaz forme za izmenu sudije.
     */
    public function edit(Sudija $sudija)
    {
        return view('sudije.edit', compact('sudija'));
    }

    /**
     * Ažuriranje sudije.
     */
    public function update(Request $request, Sudija $sudija)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'nacionalnost' => 'required|string|max:100',
        ]);

        $sudija->update($validated);

        return redirect()->route('sudije.index')
            ->with('success', 'Sudija uspešno ažuriran.');
    }

    /**
     * Brisanje sudije.
     */
    public function destroy(Sudija $sudija)
    {
        try {
            $sudija->delete();
            return redirect()->route('sudije.index')
                ->with('success', 'Sudija uspešno obrisan.');
        } catch (\Exception $e) {
            return redirect()->route('sudije.index')
                ->with('error', 'Sudiju nije moguće obrisati jer se koristi u drugim tabelama.');
        }
    }
}