<?php

namespace App\Http\Controllers;

use App\Models\Igrac;
use App\Models\Tim;
use Illuminate\Http\Request;

class IgraciController extends Controller
{
    /**
     * Prikaz svih igrača.
     */
    public function index()
    {
        $igraci = Igrac::with('tim')->orderBy('prezime')->paginate(20);
        return view('igraci.index', compact('igraci'));
    }

    /**
     * Prikaz forme za kreiranje igrača.
     */
    public function create()
    {
        $timovi = Tim::orderBy('naziv')->get();
        return view('igraci.create', compact('timovi'));
    }

    /**
     * Čuvanje novog igrača.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'tim_id' => 'required|exists:timovi,id',
            'broj_dresa' => 'nullable|integer|min:1',
            'pozicija' => 'nullable|string|max:100',
            'klub' => 'nullable|string|max:255',
            'drzava_kluba' => 'nullable|string|max:100',
            'datum_rodjenja' => 'nullable|date',
            'nacionalnost' => 'nullable|string|max:100',
        ]);

        Igrac::create($validated);

        return redirect()->route('igraci.index')
            ->with('success', 'Igrač uspešno kreiran.');
    }

    /**
     * Prikaz pojedinačnog igrača.
     */
    public function show(Igrac $igrac)
    {
        $igrac->load(['tim', 'golovi.utakmica', 'kartoni.utakmica']);
        return view('igraci.show', compact('igrac'));
    }

    /**
     * Prikaz forme za izmenu igrača.
     */
    public function edit(Igrac $igrac)
    {
        $timovi = Tim::orderBy('naziv')->get();
        return view('igraci.edit', compact('igrac', 'timovi'));
    }

    /**
     * Ažuriranje igrača.
     */
    public function update(Request $request, Igrac $igrac)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'tim_id' => 'required|exists:timovi,id',
            'broj_dresa' => 'nullable|integer|min:1',
            'pozicija' => 'nullable|string|max:100',
            'klub' => 'nullable|string|max:255',
            'drzava_kluba' => 'nullable|string|max:100',
            'datum_rodjenja' => 'nullable|date',
            'nacionalnost' => 'nullable|string|max:100',
        ]);

        $igrac->update($validated);

        return redirect()->route('igraci.index')
            ->with('success', 'Igrač uspešno ažuriran.');
    }

    /**
     * Brisanje igrača.
     */
    public function destroy(Igrac $igrac)
    {
        try {
            $igrac->delete();
            return redirect()->route('igraci.index')
                ->with('success', 'Igrač uspešno obrisan.');
        } catch (\Exception $e) {
            return redirect()->route('igraci.index')
                ->with('error', 'Igrača nije moguće obrisati jer se koristi u drugim tabelama.');
        }
    }
}