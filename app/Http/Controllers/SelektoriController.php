<?php

namespace App\Http\Controllers;

use App\Models\Selektor;
use App\Models\SelektorMandat;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 

class SelektoriController extends Controller
{
    /**
     * Prikaz svih selektora.
     */
    public function index()
    {
        // Dohvati sve selektore sa njihovim mandatima
        $selektori = Selektor::with('mandati')->get();
        
        // Sortiraj selektore po datumu početka poslednjeg mandata (najnoviji prvo)
        $selektori = $selektori->sortByDesc(function($selektor) {
            // Za selektore bez mandata, stavi ih na kraj liste (null će biti na kraju)
            if ($selektor->mandati->isEmpty()) {
                return null;
            }
            
            // Uzmi datum početka najnovijeg mandata
            return $selektor->mandati->max('pocetak_mandata');
        });
        
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
        $selektor->load(['mandati.tim']);
        
        $timovi = Tim::orderBy('naziv')->get();
        
        // Dohvati sve ostale selektore za komisije
        $ostaliSelektori = Selektor::where('id', '!=', $selektor->id)
            ->orderBy('prezime')
            ->orderBy('ime')
            ->get();
        
        return view('selektori.show', compact('selektor', 'timovi', 'ostaliSelektori'));
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
                // Convert string ID to integer for comparison
                $mandatId = (int)$id;
                
                // Check if the mandate exists and belongs to this selector
                $postojeciMandat = SelektorMandat::where('id', $mandatId)
                    ->where('selektor_id', $selektor->id)
                    ->first();
                    
                if ($postojeciMandat) {
                    if (isset($mandat['_delete']) && $mandat['_delete'] == 1) {
                        // Delete this mandate
                        $postojeciMandat->delete();
                    } else {
                        // Prepare valid data for update
                        $mandatData = [
                            'tim_id' => $mandat['tim_id'],
                            'pocetak_mandata' => $mandat['pocetak_mandata'],
                            'kraj_mandata' => !empty($mandat['kraj_mandata']) ? $mandat['kraj_mandata'] : null,
                            'v_d_status' => isset($mandat['v_d_status']) ? true : false,
                            'napomena' => $mandat['napomena'] ?? null,
                        ];
                        
                        // Update mandate
                        $postojeciMandat->update($mandatData);
                    }
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
     * Dodavanje novog mandata selektoru
     */
    public function dodajMandat(Request $request, Selektor $selektor)
    {
        // Validacija
        $validated = $request->validate([
            'tim_id' => 'required|exists:timovi,id',
            'pocetak_mandata' => 'required|date',
            'kraj_mandata' => 'nullable|date|after_or_equal:pocetak_mandata',
            'v_d_status' => 'nullable|boolean',
            'komisija' => 'nullable|boolean',
            'glavni_selektor' => 'nullable|boolean',
            'selektori_ids' => 'nullable|array',
            'selektori_ids.*' => 'exists:selektori,id',
            'napomena' => 'nullable|string',
        ]);

        // Ako je komisija, provera da li je glavni selektor
        $isKomisija = isset($validated['komisija']) && $validated['komisija'];
        $isGlavniSelektor = isset($validated['glavni_selektor']) && $validated['glavni_selektor'];

        // Koristi transakciju za kreiranje povezanih entiteta
        DB::transaction(function() use ($validated, $selektor, $isKomisija, $isGlavniSelektor) {
            // Kreiraj mandat
            $mandat = SelektorMandat::create([
                'selektor_id' => $selektor->id,
                'tim_id' => $validated['tim_id'],
                'pocetak_mandata' => $validated['pocetak_mandata'],
                'kraj_mandata' => $validated['kraj_mandata'],
                'v_d_status' => isset($validated['v_d_status']),
                'komisija' => $isKomisija,
                'redosled_u_komisiji' => $isGlavniSelektor ? 1 : 2,
                'glavni_selektor' => $isGlavniSelektor,
                'napomena' => $validated['napomena'] ?? null,
            ]);

            // Ako je komisija i imamo selektore za dodati
            if ($isKomisija && !empty($validated['selektori_ids'])) {
                $redosled = $isGlavniSelektor ? 2 : 1;
                
                foreach ($validated['selektori_ids'] as $selektorId) {
                    // Preskoci ako je ovaj selektor (već dodan)
                    if ($selektorId == $selektor->id) {
                        continue;
                    }
                    
                    SelektorMandat::create([
                        'selektor_id' => $selektorId,
                        'tim_id' => $validated['tim_id'],
                        'pocetak_mandata' => $validated['pocetak_mandata'],
                        'kraj_mandata' => $validated['kraj_mandata'],
                        'v_d_status' => isset($validated['v_d_status']),
                        'komisija' => true,
                        'redosled_u_komisiji' => $redosled++,
                        'glavni_selektor' => false,
                        'napomena' => $validated['napomena'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('selektori.show', $selektor)
            ->with('success', 'Mandat je uspešno dodat.');
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