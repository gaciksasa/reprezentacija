<?php

namespace App\Http\Controllers;

use App\Models\Stadion;
use Illuminate\Http\Request;

class StadioniController extends Controller
{
    /**
     * Prikaz svih stadiona.
     */
    public function index()
    {
        $stadioni = Stadion::orderBy('naziv')->get();
        return view('stadioni.index', compact('stadioni'));
    }

    /**
     * Prikaz forme za kreiranje stadiona.
     */
    public function create()
    {
        return view('stadioni.create');
    }

    /**
     * Čuvanje novog stadiona.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'grad' => 'required|string|max:100',
            'zemlja' => 'required|string|max:100',
            'kapacitet' => 'nullable|integer|min:0',
        ]);

        Stadion::create($validated);

        return redirect()->route('stadioni.index')
            ->with('success', 'Stadion uspešno kreiran.');
    }

    /**
     * Prikaz pojedinačnog stadiona.
     */
    public function show(Stadion $stadion)
    {
        $utakmice = $stadion->utakmice()->with(['domacin', 'gost'])->orderBy('datum', 'desc')->get();
        return view('stadioni.show', compact('stadion', 'utakmice'));
    }

    /**
     * Prikaz forme za izmenu stadiona.
     */
    public function edit(Stadion $stadion)
    {
        return view('stadioni.edit', compact('stadion'));
    }

    /**
     * Ažuriranje stadiona.
     */
    public function update(Request $request, Stadion $stadion)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'grad' => 'required|string|max:100',
            'zemlja' => 'required|string|max:100',
            'kapacitet' => 'nullable|integer|min:0',
        ]);

        $stadion->update($validated);

        return redirect()->route('stadioni.index')
            ->with('success', 'Stadion uspešno ažuriran.');
    }

    /**
     * Brisanje stadiona.
     */
    public function destroy(Stadion $stadion)
    {
        try {
            $stadion->delete();
            return redirect()->route('stadioni.index')
                ->with('success', 'Stadion uspešno obrisan.');
        } catch (\Exception $e) {
            return redirect()->route('stadioni.index')
                ->with('error', 'Stadion nije moguće obrisati jer se koristi u drugim tabelama.');
        }
    }
}