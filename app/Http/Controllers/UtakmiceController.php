<?php

namespace App\Http\Controllers;

use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Takmicenje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtakmiceController extends Controller
{
    /**
     * Prikaz svih utakmica.
     */
    public function index()
    {
        $utakmice = Utakmica::with(['domacin', 'gost'])
            ->orderBy('datum', 'desc')
            ->paginate(10);
        return view('utakmice.index', compact('utakmice'));
    }

    /**
     * Prikaz forme za kreiranje utakmice.
     */
    public function create()
    {
        $timovi = Tim::orderBy('naziv')->get();
        return view('utakmice.create', compact('timovi'));
    }

    /**
     * Čuvanje nove utakmice.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'datum' => 'required|date',
            'takmicenje' => 'required|string|max:255',
            'domacin_id' => 'required|exists:timovi,id',
            'gost_id' => 'required|exists:timovi,id|different:domacin_id',
            'stadion' => 'nullable|string|max:255',
            'sudija' => 'nullable|string|max:255',
            'publika' => 'nullable|string|max:255',
        ]);

        // Create or find the competition
        $takmicenje = Takmicenje::firstOrCreate(
            ['naziv' => $validated['takmicenje']],
            ['organizator' => null]
        );

        // Prepare data for creating the match
        $utakmicaData = [
            'datum' => $validated['datum'],
            'takmicenje_id' => $takmicenje->id,
            'domacin_id' => $validated['domacin_id'],
            'gost_id' => $validated['gost_id'],
            'stadion' => $validated['stadion'] ?? null,
            'sudija' => $validated['sudija'] ?? null,
            'publika' => $validated['publika'] ?? null,
            'rezultat_domacin' => 0,
            'rezultat_gost' => 0
        ];

        // Use transaction to ensure all related data is saved successfully
        DB::transaction(function() use ($utakmicaData) {
            Utakmica::create($utakmicaData);
        });

        return redirect()->route('utakmice.index')
            ->with('success', 'Utakmica uspešno kreirana.');
    }

    /**
     * Prikaz pojedinog detalja utakmice.
     */
    public function show($id)
    {
        $utakmica = Utakmica::with([
            'domacin', 
            'gost', 
            'sastavi.igrac', 
            'golovi.igrac', 
            'izmene.igracOut', 
            'izmene.igracIn', 
            'kartoni.igrac'
        ])->findOrFail($id);
        
        return view('utakmice.show', compact('utakmica'));
    }

    /**
     * Prikaz forme za izmenu utakmice.
     */
    public function edit(Utakmica $utakmica)
    {
        $timovi = Tim::orderBy('naziv')->get();
        $takmicenja = Takmicenje::orderBy('naziv')->get();
        
        return view('utakmice.edit', compact('utakmica', 'timovi', 'takmicenja'));
    }

    /**
     * Ažuriranje utakmice.
     */
    public function update(Request $request, Utakmica $utakmica)
    {
        $validated = $request->validate([
            'datum' => 'required|date',
            'takmicenje' => 'required|string|max:255',
            'domacin_id' => 'required|exists:timovi,id',
            'gost_id' => 'required|exists:timovi,id|different:domacin_id',
            'stadion' => 'nullable|string|max:255',
            'sudija' => 'nullable|string|max:255',
            'publika' => 'nullable|string|max:255',
        ]);

        // Create or find the competition
        $takmicenje = Takmicenje::firstOrCreate(
            ['naziv' => $validated['takmicenje']],
            ['organizator' => null]
        );

        // Prepare data for updating the match
        $utakmicaData = [
            'datum' => $validated['datum'],
            'takmicenje_id' => $takmicenje->id,
            'domacin_id' => $validated['domacin_id'],
            'gost_id' => $validated['gost_id'],
            'stadion' => $validated['stadion'] ?? null,
            'sudija' => $validated['sudija'] ?? null,
            'publika' => $validated['publika'] ?? null,
        ];

        $utakmica->update($utakmicaData);

        return redirect()->route('utakmice.index')
            ->with('success', 'Utakmica uspešno ažurirana.');
    }

    /**
     * Brisanje utakmice.
     */
    public function destroy(Utakmica $utakmica)
    {
        try {
            $utakmica->delete();
            return redirect()->route('utakmice.index')
                ->with('success', 'Utakmica uspešno obrisana.');
        } catch (\Exception $e) {
            return redirect()->route('utakmice.index')
                ->with('error', 'Utakmicu nije moguće obrisati jer se koristi u drugim tabelama.');
        }
    }

    /**
     * Ažuriranje rezultata utakmice na osnovu golova.
     * This method can be called separately to recalculate score.
     */
    public function updateScore(Utakmica $utakmica)
    {
        // Count goals for home team
        $domacin_golovi = $utakmica->golovi()
            ->where(function($query) use ($utakmica) {
                $query->where(function($q) use ($utakmica) {
                    $q->where('tim_id', $utakmica->domacin_id)
                      ->where('auto_gol', false);
                })->orWhere(function($q) use ($utakmica) {
                    $q->where('tim_id', $utakmica->gost_id)
                      ->where('auto_gol', true);
                });
            })
            ->count();
            
        // Count goals for away team
        $gost_golovi = $utakmica->golovi()
            ->where(function($query) use ($utakmica) {
                $query->where(function($q) use ($utakmica) {
                    $q->where('tim_id', $utakmica->gost_id)
                      ->where('auto_gol', false);
                })->orWhere(function($q) use ($utakmica) {
                    $q->where('tim_id', $utakmica->domacin_id)
                      ->where('auto_gol', true);
                });
            })
            ->count();
            
        // Update match with new calculated scores
        $utakmica->update([
            'rezultat_domacin' => $domacin_golovi,
            'rezultat_gost' => $gost_golovi
        ]);
        
        return $utakmica;
    }
}