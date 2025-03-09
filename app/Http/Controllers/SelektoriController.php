<?php

namespace App\Http\Controllers;

use App\Models\Selektor;
use App\Models\SelektorMandat;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SelektoriController extends Controller
{
    /**
     * Prikaz svih selektora.
     */
    public function index()
    {
        $selektori = Selektor::with('mandati.tim')->orderBy('prezime')->get();
        return view('selektori.index', compact('selektori'));
    }

    /**
     * Prikaz forme za kreiranje selektora.
     */
    public function create()
    {
        $timovi = Tim::where(function($query) {
            // Glavni tim
            $query->where('glavni_tim', true)
                  // ili bilo koji alijas glavnog tima
                  ->orWhereHas('maticniTim', function($q) {
                      $q->where('glavni_tim', true);
                  });
        })->orderBy('naziv')->get();
        
        return view('selektori.create', compact('timovi'));
    }

    /**
     * Čuvanje novog selektora.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'datum_rodjenja' => 'nullable|date',
            'mesto_rodjenja' => 'nullable|string|max:255',
            'datum_smrti' => 'nullable|date|after_or_equal:datum_rodjenja',
            'mesto_smrti' => 'nullable|string|max:255',
            'drzavljanstvo' => 'nullable|string|max:255',
            'biografija' => 'nullable|string',
            'fotografija' => 'nullable|image|max:2048',
            'tim_id' => 'required|exists:timovi,id',
            'pocetak_mandata' => 'required|date',
            'kraj_mandata' => 'nullable|date|after_or_equal:pocetak_mandata',
            'v_d_status' => 'boolean',
            'napomena' => 'nullable|string',
        ]);

        // Handle file upload if there's a photo
        if ($request->hasFile('fotografija')) {
            $path = $request->file('fotografija')->store('selektori', 'public');
            $validated['fotografija_path'] = $path;
        }

        // Create selector
        $selektor = Selektor::create([
            'ime' => $validated['ime'],
            'prezime' => $validated['prezime'],
            'datum_rodjenja' => $validated['datum_rodjenja'],
            'mesto_rodjenja' => $validated['mesto_rodjenja'],
            'datum_smrti' => $validated['datum_smrti'],
            'mesto_smrti' => $validated['mesto_smrti'],
            'drzavljanstvo' => $validated['drzavljanstvo'],
            'biografija' => $validated['biografija'],
            'fotografija_path' => $validated['fotografija_path'] ?? null,
        ]);

        // Create mandate
        SelektorMandat::create([
            'selektor_id' => $selektor->id,
            'tim_id' => $validated['tim_id'],
            'pocetak_mandata' => $validated['pocetak_mandata'],
            'kraj_mandata' => $validated['kraj_mandata'],
            'v_d_status' => $request->has('v_d_status'),
            'napomena' => $validated['napomena'],
        ]);

        return redirect()->route('selektori.index')
            ->with('success', 'Selektor uspešno kreiran.');
    }

    /**
     * Prikaz pojedinačnog selektora.
     */
    public function show(Selektor $selektor)
    {
        $selektor->load('mandati.tim');
        
        $timovi = Tim::where(function($query) {
            // Glavni tim
            $query->where('glavni_tim', true)
                  // ili bilo koji alijas glavnog tima
                  ->orWhereHas('maticniTim', function($q) {
                      $q->where('glavni_tim', true);
                  });
        })->orderBy('naziv')->get();
        
        return view('selektori.show', compact('selektor', 'timovi'));
    }

    /**
     * Prikaz forme za izmenu selektora.
     */
    public function edit(Selektor $selektor)
    {
        $selektor->load('mandati.tim');
        
        $timovi = Tim::where(function($query) {
            // Glavni tim
            $query->where('glavni_tim', true)
                  // ili bilo koji alijas glavnog tima
                  ->orWhereHas('maticniTim', function($q) {
                      $q->where('glavni_tim', true);
                  });
        })->orderBy('naziv')->get();
        
        return view('selektori.edit', compact('selektor', 'timovi'));
    }

    /**
     * Ažuriranje selektora.
     */
    public function update(Request $request, Selektor $selektor)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'datum_rodjenja' => 'nullable|date',
            'mesto_rodjenja' => 'nullable|string|max:255',
            'datum_smrti' => 'nullable|date|after_or_equal:datum_rodjenja',
            'mesto_smrti' => 'nullable|string|max:255',
            'drzavljanstvo' => 'nullable|string|max:255',
            'biografija' => 'nullable|string',
            'fotografija' => 'nullable|image|max:2048',
        ]);

        // Handle file upload if there's a new photo
        if ($request->hasFile('fotografija')) {
            // Delete old photo if exists
            if ($selektor->fotografija_path) {
                Storage::disk('public')->delete($selektor->fotografija_path);
            }
            
            $path = $request->file('fotografija')->store('selektori', 'public');
            $validated['fotografija_path'] = $path;
        }

        $selektor->update($validated);

        // Update existing mandates if provided
        if ($request->has('mandati')) {
            foreach ($request->mandati as $id => $mandat) {
                if (isset($mandat['_delete']) && $mandat['_delete'] == 1) {
                    // Delete this mandate
                    SelektorMandat::findOrFail($id)->delete();
                } else {
                    // Update mandate
                    SelektorMandat::findOrFail($id)->update([
                        'tim_id' => $mandat['tim_id'],
                        'pocetak_mandata' => $mandat['pocetak_mandata'],
                        'kraj_mandata' => $mandat['kraj_mandata'],
                        'v_d_status' => isset($mandat['v_d_status']),
                        'napomena' => $mandat['napomena'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('selektori.show', $selektor)
            ->with('success', 'Selektor uspešno ažuriran.');
    }

    /**
     * Brisanje selektora.
     */
    public function destroy(Selektor $selektor)
    {
        try {
            // Delete associated photo if exists
            if ($selektor->fotografija_path) {
                Storage::disk('public')->delete($selektor->fotografija_path);
            }
            
            // Delete the selector (mandates will be cascade deleted)
            $selektor->delete();
            
            return redirect()->route('selektori.index')
                ->with('success', 'Selektor uspešno obrisan.');
        } catch (\Exception $e) {
            return redirect()->route('selektori.index')
                ->with('error', 'Selektora nije moguće obrisati: ' . $e->getMessage());
        }
    }

    /**
     * Dodaj novi mandat selektoru.
     */
    public function dodajMandat(Request $request, Selektor $selektor)
    {
        $validated = $request->validate([
            'tim_id' => 'required|exists:timovi,id',
            'pocetak_mandata' => 'required|date',
            'kraj_mandata' => 'nullable|date|after_or_equal:pocetak_mandata',
            'v_d_status' => 'boolean',
            'napomena' => 'nullable|string',
        ]);

        SelektorMandat::create([
            'selektor_id' => $selektor->id,
            'tim_id' => $validated['tim_id'],
            'pocetak_mandata' => $validated['pocetak_mandata'],
            'kraj_mandata' => $validated['kraj_mandata'],
            'v_d_status' => $request->has('v_d_status'),
            'napomena' => $validated['napomena'],
        ]);

        return redirect()->route('selektori.show', $selektor)
            ->with('success', 'Mandat uspešno dodat.');
    }

    /**
     * Obrisi mandat selektora.
     */
    public function obrisiMandat(SelektorMandat $mandat)
    {
        $selektor_id = $mandat->selektor_id;
        $mandat->delete();
        
        return redirect()->route('selektori.show', $selektor_id)
            ->with('success', 'Mandat uspešno obrisan.');
    }
}