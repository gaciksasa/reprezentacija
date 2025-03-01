<?php

namespace App\Http\Controllers;

use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Takmicenje;
use App\Models\Stadion;
use App\Models\Sudija;
use Illuminate\Http\Request;

class UtakmiceController extends Controller
{
    /**
     * Prikaz svih utakmica.
     */
    public function index()
    {
        $utakmice = Utakmica::with(['domacin', 'gost', 'takmicenje'])
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
        $takmicenja = Takmicenje::orderBy('naziv')->get();
        $stadioni = Stadion::orderBy('naziv')->get();
        $sudije = Sudija::orderBy('prezime')->get();
        
        return view('utakmice.create', compact('timovi', 'takmicenja', 'stadioni', 'sudije'));
    }

    /**
     * Čuvanje nove utakmice.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'datum' => 'required|date',
            'vreme' => 'nullable|date_format:H:i',
            'takmicenje_id' => 'required|exists:takmicenja,id',
            'domacin_id' => 'required|exists:timovi,id',
            'gost_id' => 'required|exists:timovi,id|different:domacin_id',
            'stadion_id' => 'nullable|exists:stadioni,id',
            'rezultat_domacin' => 'nullable|integer|min:0',
            'rezultat_gost' => 'nullable|integer|min:0',
            'poluvreme_rezultat_domacin' => 'nullable|integer|min:0',
            'poluvreme_rezultat_gost' => 'nullable|integer|min:0',
            'sudija_id' => 'nullable|exists:sudije,id',
            'publika' => 'nullable|string|max:255',
            'sezona' => 'nullable|string|max:50',
        ]);

        Utakmica::create($validated);

        return redirect()->route('utakmice.index')
            ->with('success', 'Utakmica uspešno kreirana.');
    }

    /**
     * Prikaz pojedine utakmice.
     */
    public function show($id)
    {
        $utakmica = Utakmica::with(['domacin', 'gost', 'takmicenje', 'stadion', 'sudija'])->findOrFail($id);
        
        // Dodatna provera da li relacije postoje
        if (!$utakmica->domacin || !$utakmica->gost) {
            return redirect()->route('utakmice.index')
                ->with('error', 'Utakmica ima nevažeću referencu na tim.');
        }
        
        return view('utakmice.show', compact('utakmica'));
    }

    /**
     * Prikaz forme za izmenu utakmice.
     */
    public function edit(Utakmica $utakmica)
    {
        $timovi = Tim::orderBy('naziv')->get();
        $takmicenja = Takmicenje::orderBy('naziv')->get();
        $stadioni = Stadion::orderBy('naziv')->get();
        $sudije = Sudija::orderBy('prezime')->get();
        
        return view('utakmice.edit', compact('utakmica', 'timovi', 'takmicenja', 'stadioni', 'sudije'));
    }

    /**
     * Ažuriranje utakmice.
     */
    public function update(Request $request, Utakmica $utakmica)
    {
        $validated = $request->validate([
            'datum' => 'required|date',
            'vreme' => 'nullable|date_format:H:i',
            'takmicenje_id' => 'required|exists:takmicenja,id',
            'domacin_id' => 'required|exists:timovi,id',
            'gost_id' => 'required|exists:timovi,id|different:domacin_id',
            'stadion_id' => 'nullable|exists:stadioni,id',
            'rezultat_domacin' => 'nullable|integer|min:0',
            'rezultat_gost' => 'nullable|integer|min:0',
            'poluvreme_rezultat_domacin' => 'nullable|integer|min:0',
            'poluvreme_rezultat_gost' => 'nullable|integer|min:0',
            'sudija_id' => 'nullable|exists:sudije,id',
            'publika' => 'nullable|string|max:255',
            'sezona' => 'nullable|string|max:50',
        ]);

        $utakmica->update($validated);

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
}