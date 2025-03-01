<?php

namespace App\Http\Controllers;

use App\Models\Izmena;
use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
use Illuminate\Http\Request;

class IzmeneController extends Controller
{
    /**
     * Prikaz izmena za određenu utakmicu.
     */
    public function index(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        
        if ($utakmica_id) {
            $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
            
            $izmene = Izmena::where('utakmica_id', $utakmica_id)
                ->with(['tim', 'igracOut', 'igracIn'])
                ->orderBy('minut')
                ->get();
                
            return view('izmene.index', compact('utakmica', 'izmene'));
        }
        
        $utakmice = Utakmica::with(['domacin', 'gost'])
            ->orderBy('datum', 'desc')
            ->paginate(10);
            
        return view('izmene.select_utakmica', compact('utakmice'));
    }

    /**
     * Prikaz forme za dodavanje izmene.
     */
    public function create(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        $tim_id = $request->query('tim_id');
        
        if (!$utakmica_id || !$tim_id) {
            return redirect()->route('izmene.index')
                ->with('error', 'Morate izabrati utakmicu i tim.');
        }
        
        $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
        $tim = Tim::findOrFail($tim_id);
        
        // Provera da li je tim učesnik utakmice
        if ($utakmica->domacin_id != $tim_id && $utakmica->gost_id != $tim_id) {
            return redirect()->route('izmene.index', ['utakmica_id' => $utakmica_id])
                ->with('error', 'Izabrani tim nije učesnik ove utakmice.');
        }
        
        // Igrači tima koji su u sastavu ove utakmice
        $igraci = Igrac::where('tim_id', $tim_id)->orderBy('prezime')->get();
        
        return view('izmene.create', compact('utakmica', 'tim', 'igraci'));
    }

    /**
     * Čuvanje nove izmene.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'utakmica_id' => 'required|exists:utakmice,id',
            'tim_id' => 'required|exists:timovi,id',
            'igrac_out_id' => 'required|exists:igraci,id',
            'igrac_in_id' => 'required|exists:igraci,id|different:igrac_out_id',
            'minut' => 'required|integer|min:1|max:120',
        ]);

        Izmena::create($validated);

        return redirect()->route('izmene.index', ['utakmica_id' => $validated['utakmica_id']])
            ->with('success', 'Izmena uspešno zabeležena.');
    }

    /**
     * Prikaz pojedinačne izmene.
     */
    public function show(Izmena $izmena)
    {
        $izmena->load(['utakmica', 'tim', 'igracOut', 'igracIn']);
        return view('izmene.show', compact('izmena'));
    }

    /**
     * Prikaz forme za izmenu izmene.
     */
    public function edit(Izmena $izmena)
    {
        $izmena->load(['utakmica.domacin', 'utakmica.gost', 'tim', 'igracOut', 'igracIn']);
        
        $igraci = Igrac::where('tim_id', $izmena->tim_id)->orderBy('prezime')->get();
        
        return view('izmene.edit', compact('izmena', 'igraci'));
    }

    /**
     * Ažuriranje izmene.
     */
    public function update(Request $request, Izmena $izmena)
    {
        $validated = $request->validate([
            'igrac_out_id' => 'required|exists:igraci,id',
            'igrac_in_id' => 'required|exists:igraci,id|different:igrac_out_id',
            'minut' => 'required|integer|min:1|max:120',
        ]);

        $izmena->update($validated);

        return redirect()->route('izmene.index', ['utakmica_id' => $izmena->utakmica_id])
            ->with('success', 'Izmena uspešno ažurirana.');
    }

    /**
     * Brisanje izmene.
     */
    public function destroy(Izmena $izmena)
    {
        $utakmica_id = $izmena->utakmica_id;
        $izmena->delete();
        
        return redirect()->route('izmene.index', ['utakmica_id' => $utakmica_id])
            ->with('success', 'Izmena uspešno obrisana.');
    }
}