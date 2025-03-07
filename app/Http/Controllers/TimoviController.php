<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use Illuminate\Http\Request;

class TimoviController extends Controller
{
    /**
     * Prikaz svih timova.
     */
    public function index()
    {
        // Dobavi glavni tim i njegove alijase
        $glavniTim = Tim::glavniTim()->first();
        
        // Ukoliko postoji glavni tim, prikupi sve njegove ID-ove i ID-ove njegovih alijasa
        $iskljuceniTimIds = [];
        if ($glavniTim) {
            $iskljuceniTimIds = $glavniTim->getSviIdTimova();
        }
        
        // Dohvati sve timove OSIM glavnog tima i njegovih alijasa
        $timovi = Tim::whereNotIn('id', $iskljuceniTimIds)
                    ->orderBy('naziv')
                    ->get();
                    
        return view('timovi.index', compact('timovi'));
    }

    /**
     * Prikaz forme za kreiranje tima.
     */
    public function create()
    {
        return view('timovi.create');
    }

    /**
     * Čuvanje novog tima.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'skraceni_naziv' => 'nullable|string|max:50',
            'zemlja' => 'required|string|max:100',
            'zastava_url' => 'nullable|string|max:255',
            'grb_url' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('grb')) {
            $file = $request->file('grb');
            $filename = strtolower($validated['skraceni_naziv']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/grbovi'), $filename);
            $validated['grb_url'] = $filename;
        }

        Tim::create($validated);

        return redirect()->route('timovi.index')
            ->with('success', 'Tim uspešno kreiran.');
    }

    /**
     * Prikaz pojedinog tima.
     */
    public function show(Tim $tim)
    {
        $tim->load(['igraci', 'domaceUtakmice', 'gostujuceUtakmice']);
        return view('timovi.show', compact('tim'));
    }

    /**
     * Prikaz forme za izmenu tima.
     */
    public function edit(Tim $tim)
    {
        return view('timovi.edit', compact('tim'));
    }

    /**
     * Ažuriranje tima.
     */
    public function update(Request $request, Tim $tim)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'skraceni_naziv' => 'nullable|string|max:50',
            'zemlja' => 'required|string|max:100',
            'zastava_url' => 'nullable|string|max:255',
            'grb_url' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('grb')) {
            $file = $request->file('grb');
            $filename = strtolower($validated['skraceni_naziv']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/grbovi'), $filename);
            $validated['grb_url'] = $filename;
        }

        $tim->update($validated);

        return redirect()->route('timovi.index')
            ->with('success', 'Tim uspešno ažuriran.');
    }

    /**
     * Brisanje tima.
     */
    public function destroy(Tim $tim)
    {
        try {
            $tim->delete();
            return redirect()->route('timovi.index')
                ->with('success', 'Tim uspešno obrisan.');
        } catch (\Exception $e) {
            return redirect()->route('timovi.index')
                ->with('error', 'Tim nije moguće obrisati jer se koristi u drugim tabelama.');
        }
    }
}