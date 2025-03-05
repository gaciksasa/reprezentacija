<?php

namespace App\Http\Controllers;

use App\Models\ProtivnickiIgrac;
use App\Models\Utakmica;
use App\Models\Tim;
use Illuminate\Http\Request;

class ProtivnickiIgraciController extends Controller
{
    /**
     * Prikaz protivničkih igrača za određenu utakmicu i tim.
     */
    public function index(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        $tim_id = $request->query('tim_id');
        
        if (!$utakmica_id || !$tim_id) {
            return redirect()->route('utakmice.index')
                ->with('error', 'Morate izabrati utakmicu i tim.');
        }
        
        $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
        $tim = Tim::findOrFail($tim_id);
        
        // Provera da li je tim učesnik utakmice
        if ($utakmica->domacin_id != $tim_id && $utakmica->gost_id != $tim_id) {
            return redirect()->route('utakmice.show', $utakmica)
                ->with('error', 'Izabrani tim nije učesnik ove utakmice.');
        }
        
        // Provera da li je tim protivnik našeg tima
        $nasTimId = Tim::glavniTim()->first()->id ?? null;
        if ($tim_id == $nasTimId || in_array($tim_id, Tim::glavniTim()->first()->getSviIdTimova() ?? [])) {
            return redirect()->route('utakmice.show', $utakmica)
                ->with('error', 'Ovo je opcija samo za protivnički tim.');
        }
        
        $protivnickiIgraci = ProtivnickiIgrac::where('utakmica_id', $utakmica_id)
            ->where('tim_id', $tim_id)
            ->orderBy('kapiten', 'desc')
            ->orderBy('prezime')
            ->get();
            
        return view('protivnicki-igraci.index', compact('utakmica', 'tim', 'protivnickiIgraci'));
    }

    /**
     * Prikaz forme za dodavanje protivničkog igrača.
     */
    public function create(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        $tim_id = $request->query('tim_id');
        
        if (!$utakmica_id || !$tim_id) {
            return redirect()->route('utakmice.index')
                ->with('error', 'Morate izabrati utakmicu i tim.');
        }
        
        $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
        $tim = Tim::findOrFail($tim_id);
        
        // Provera da li je tim učesnik utakmice
        if ($utakmica->domacin_id != $tim_id && $utakmica->gost_id != $tim_id) {
            return redirect()->route('utakmice.show', $utakmica)
                ->with('error', 'Izabrani tim nije učesnik ove utakmice.');
        }
        
        // Provera da li je tim protivnik našeg tima
        $nasTimId = Tim::glavniTim()->first()->id ?? null;
        if ($tim_id == $nasTimId || in_array($tim_id, Tim::glavniTim()->first()->getSviIdTimova() ?? [])) {
            return redirect()->route('utakmice.show', $utakmica)
                ->with('error', 'Ovo je opcija samo za protivnički tim.');
        }
        
        return view('protivnicki-igraci.create', compact('utakmica', 'tim'));
    }

    /**
     * Čuvanje novog protivničkog igrača.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'utakmica_id' => 'required|exists:utakmice,id',
            'tim_id' => 'required|exists:timovi,id',
            'kapiten' => 'boolean',
        ]);
        
        // Postavljamo podrazumevanu vrednost za kapiten
        $validated['kapiten'] = $request->has('kapiten');
        
        // Kreiramo protivničkog igrača
        $protivnickiIgrac = ProtivnickiIgrac::create($validated);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'igrac' => $protivnickiIgrac
            ]);
        }
        
        return redirect()->route('protivnicki-igraci.index', [
                'utakmica_id' => $validated['utakmica_id'], 
                'tim_id' => $validated['tim_id']
            ])
            ->with('success', 'Protivnički igrač uspešno dodat.');
    }

    /**
     * Prikaz forme za izmenu protivničkog igrača.
     */
    public function edit(ProtivnickiIgrac $protivnickiIgrac)
    {
        $protivnickiIgrac->load(['utakmica', 'tim']);
        return view('protivnicki-igraci.edit', compact('protivnickiIgrac'));
    }

    /**
     * Ažuriranje protivničkog igrača.
     */
    public function update(Request $request, ProtivnickiIgrac $protivnickiIgrac)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'kapiten' => 'boolean',
        ]);
        
        // Postavljamo podrazumevanu vrednost za kapiten
        $validated['kapiten'] = $request->has('kapiten');
        
        $protivnickiIgrac->update($validated);
        
        return redirect()->route('protivnicki-igraci.index', [
                'utakmica_id' => $protivnickiIgrac->utakmica_id, 
                'tim_id' => $protivnickiIgrac->tim_id
            ])
            ->with('success', 'Protivnički igrač uspešno ažuriran.');
    }

    /**
     * Brisanje protivničkog igrača.
     */
    public function destroy(ProtivnickiIgrac $protivnickiIgrac)
    {
        $utakmica_id = $protivnickiIgrac->utakmica_id;
        $tim_id = $protivnickiIgrac->tim_id;
        
        $protivnickiIgrac->delete();
        
        return redirect()->route('protivnicki-igraci.index', [
                'utakmica_id' => $utakmica_id, 
                'tim_id' => $tim_id
            ])
            ->with('success', 'Protivnički igrač uspešno obrisan.');
    }
}