<?php

namespace App\Http\Controllers;

use App\Models\Selektor;
use App\Models\SelektorMandat;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelektorKomisijaController extends Controller
{
    /**
     * Prikaz forme za kreiranje nove selektorske komisije
     */
    public function create()
    {
        $selektori = Selektor::orderBy('prezime')->orderBy('ime')->get();
        // Dobavljanje glavnog tima (Srbija)
        $glavniTim = Tim::glavniTim()->first();
        
        if (!$glavniTim) {
            return redirect()->route('selektori.index')
                ->with('error', 'Glavni tim nije definisan. Molimo prvo definišite glavni tim.');
        }
        
        return view('selektori.komisija.create', compact('selektori', 'glavniTim'));
    }
    
    /**
     * Čuvanje nove selektorske komisije
     */
    public function store(Request $request)
    {
        // Dobavljanje glavnog tima (Srbija)
        $glavniTim = Tim::glavniTim()->first();
        
        if (!$glavniTim) {
            return redirect()->route('selektori.index')
                ->with('error', 'Glavni tim nije definisan. Molimo prvo definišite glavni tim.');
        }
        
        $validated = $request->validate([
            'pocetak_mandata' => 'required|date',
            'kraj_mandata' => 'nullable|date|after_or_equal:pocetak_mandata',
            'napomena' => 'nullable|string',
            'glavni_selektor_id' => 'required',
            'novi_selektor' => 'nullable|array',
            'novi_selektor.ime' => 'required_with:novi_selektor.prezime',
            'novi_selektor.prezime' => 'required_with:novi_selektor.ime',
            'clanovi_komisije' => 'nullable|array',
            'clanovi_komisije.*' => 'exists:selektori,id',
            'novi_clanovi' => 'nullable|array',
            'novi_clanovi.*.ime' => 'required_with:novi_clanovi.*.prezime',
            'novi_clanovi.*.prezime' => 'required_with:novi_clanovi.*.ime',
        ]);
        
        // Koristi transakciju da bi se osiguralo da su svi članovi komisije sačuvani
        DB::transaction(function() use ($validated, $request, $glavniTim) {
            // Proveri da li je glavni selektor nov ili postojeći
            $glavniSelektorId = $validated['glavni_selektor_id'];
            
            if ($glavniSelektorId === 'novi') {
                // Kreiraj novog selektora
                $noviSelektor = Selektor::create([
                    'ime' => $validated['novi_selektor']['ime'],
                    'prezime' => $validated['novi_selektor']['prezime'],
                ]);
                $glavniSelektorId = $noviSelektor->id;
            }
            
            // Kreiranje mandata za glavnog selektora
            $glavniMandat = SelektorMandat::create([
                'selektor_id' => $glavniSelektorId,
                'tim_id' => $glavniTim->id,
                'pocetak_mandata' => $validated['pocetak_mandata'],
                'kraj_mandata' => $validated['kraj_mandata'],
                'v_d_status' => false,
                'komisija' => true,
                'redosled_u_komisiji' => 1,
                'glavni_selektor' => true,
                'napomena' => $validated['napomena'],
            ]);
            
            // Dodavanje postojećih članova komisije
            $redosled = 2;
            if (isset($validated['clanovi_komisije'])) {
                foreach ($validated['clanovi_komisije'] as $selektorId) {
                    // Preskačemo glavnog selektora jer je već dodan
                    if ($selektorId == $glavniSelektorId) {
                        continue;
                    }
                    
                    SelektorMandat::create([
                        'selektor_id' => $selektorId,
                        'tim_id' => $glavniTim->id,
                        'pocetak_mandata' => $validated['pocetak_mandata'],
                        'kraj_mandata' => $validated['kraj_mandata'],
                        'v_d_status' => false,
                        'komisija' => true,
                        'redosled_u_komisiji' => $redosled++,
                        'glavni_selektor' => false,
                        'napomena' => $validated['napomena'],
                    ]);
                }
            }
            
            // Dodavanje novih članova komisije
            if (isset($validated['novi_clanovi'])) {
                foreach ($validated['novi_clanovi'] as $noviClan) {
                    if (!empty($noviClan['ime']) && !empty($noviClan['prezime'])) {
                        // Kreiraj novog selektora
                        $noviSelektor = Selektor::create([
                            'ime' => $noviClan['ime'],
                            'prezime' => $noviClan['prezime'],
                        ]);
                        
                        // Dodaj ga u komisiju
                        SelektorMandat::create([
                            'selektor_id' => $noviSelektor->id,
                            'tim_id' => $glavniTim->id,
                            'pocetak_mandata' => $validated['pocetak_mandata'],
                            'kraj_mandata' => $validated['kraj_mandata'],
                            'v_d_status' => false,
                            'komisija' => true,
                            'redosled_u_komisiji' => $redosled++,
                            'glavni_selektor' => false,
                            'napomena' => $validated['napomena'],
                        ]);
                    }
                }
            }
        });
        
        return redirect()->route('selektori.index')
            ->with('success', 'Selektorska komisija je uspešno kreirana.');
    }
    
    /**
     * Prikaz forme za izmenu selektorske komisije
     */
    public function edit($mandatId)
    {
        $mandat = SelektorMandat::findOrFail($mandatId);
        
        // Ako mandat nije deo komisije, vrati grešku
        if (!$mandat->komisija) {
            return redirect()->back()
                ->with('error', 'Izabrani mandat nije deo selektorske komisije.');
        }
        
        // Dobavi sve članove iste komisije
        $komisijaMandati = $mandat->clanoviKomisije();
        $glavniSelektor = $komisijaMandati->where('glavni_selektor', true)->first()->selektor;
        $ostaliClanovi = $komisijaMandati->where('glavni_selektor', false)
            ->pluck('selektor_id')->toArray();
            
        $selektori = Selektor::orderBy('prezime')->orderBy('ime')->get();
        $timovi = Tim::orderBy('naziv')->get();
        
        return view('selektori.komisija.edit', compact(
            'mandat', 'komisijaMandati', 'glavniSelektor', 'ostaliClanovi',
            'selektori', 'timovi'
        ));
    }
    
    /**
     * Ažuriranje selektorske komisije
     */
    public function update(Request $request, $mandatId)
    {
        $mandat = SelektorMandat::findOrFail($mandatId);
        
        // Ako mandat nije deo komisije, vrati grešku
        if (!$mandat->komisija) {
            return redirect()->back()
                ->with('error', 'Izabrani mandat nije deo selektorske komisije.');
        }
        
        $validated = $request->validate([
            'tim_id' => 'required|exists:timovi,id',
            'pocetak_mandata' => 'required|date',
            'kraj_mandata' => 'nullable|date|after_or_equal:pocetak_mandata',
            'napomena' => 'nullable|string',
            'glavni_selektor_id' => 'required',
            'novi_selektor' => 'nullable|array',
            'novi_selektor.ime' => 'required_with:novi_selektor.prezime',
            'novi_selektor.prezime' => 'required_with:novi_selektor.ime',
            'clanovi_komisije' => 'nullable|array',
            'clanovi_komisije.*' => 'exists:selektori,id',
            'novi_clanovi' => 'nullable|array',
            'novi_clanovi.*.ime' => 'required_with:novi_clanovi.*.prezime',
            'novi_clanovi.*.prezime' => 'required_with:novi_clanovi.*.ime',
        ]);
        
        // Dobavi sve članove iste komisije
        $komisijaMandati = $mandat->clanoviKomisije();
        
        // Koristi transakciju da bi se osiguralo da su svi članovi komisije ažurirani
        DB::transaction(function() use ($validated, $komisijaMandati, $mandat) {
            // Prvo obrišemo sve postojeće mandate ove komisije
            foreach ($komisijaMandati as $postojeciMandat) {
                $postojeciMandat->delete();
            }
            
            // Proveri da li je glavni selektor nov ili postojeći
            $glavniSelektorId = $validated['glavni_selektor_id'];
            
            if ($glavniSelektorId === 'novi') {
                // Kreiraj novog selektora
                $noviSelektor = Selektor::create([
                    'ime' => $validated['novi_selektor']['ime'],
                    'prezime' => $validated['novi_selektor']['prezime'],
                ]);
                $glavniSelektorId = $noviSelektor->id;
            }
            
            // Zatim kreiramo novi mandat za glavnog selektora
            $glavniMandat = SelektorMandat::create([
                'selektor_id' => $glavniSelektorId,
                'tim_id' => $validated['tim_id'],
                'pocetak_mandata' => $validated['pocetak_mandata'],
                'kraj_mandata' => $validated['kraj_mandata'],
                'v_d_status' => false,
                'komisija' => true,
                'redosled_u_komisiji' => 1,
                'glavni_selektor' => true,
                'napomena' => $validated['napomena'],
            ]);
            
            // Dodavanje postojećih članova komisije
            $redosled = 2;
            if (isset($validated['clanovi_komisije'])) {
                foreach ($validated['clanovi_komisije'] as $selektorId) {
                    // Preskačemo glavnog selektora jer je već dodan
                    if ($selektorId == $glavniSelektorId) {
                        continue;
                    }
                    
                    SelektorMandat::create([
                        'selektor_id' => $selektorId,
                        'tim_id' => $validated['tim_id'],
                        'pocetak_mandata' => $validated['pocetak_mandata'],
                        'kraj_mandata' => $validated['kraj_mandata'],
                        'v_d_status' => false,
                        'komisija' => true,
                        'redosled_u_komisiji' => $redosled++,
                        'glavni_selektor' => false,
                        'napomena' => $validated['napomena'],
                    ]);
                }
            }
            
            // Dodavanje novih članova komisije
            if (isset($validated['novi_clanovi'])) {
                foreach ($validated['novi_clanovi'] as $noviClan) {
                    if (!empty($noviClan['ime']) && !empty($noviClan['prezime'])) {
                        // Kreiraj novog selektora
                        $noviSelektor = Selektor::create([
                            'ime' => $noviClan['ime'],
                            'prezime' => $noviClan['prezime'],
                        ]);
                        
                        // Dodaj ga u komisiju
                        SelektorMandat::create([
                            'selektor_id' => $noviSelektor->id,
                            'tim_id' => $validated['tim_id'],
                            'pocetak_mandata' => $validated['pocetak_mandata'],
                            'kraj_mandata' => $validated['kraj_mandata'],
                            'v_d_status' => false,
                            'komisija' => true,
                            'redosled_u_komisiji' => $redosled++,
                            'glavni_selektor' => false,
                            'napomena' => $validated['napomena'],
                        ]);
                    }
                }
            }
        });
        
        return redirect()->route('selektori.index')
            ->with('success', 'Selektorska komisija je uspešno ažurirana.');
    }
}