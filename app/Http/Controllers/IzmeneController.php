<?php

namespace App\Http\Controllers;

use App\Models\Izmena;
use App\Models\ProtivnickaIzmena;
use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
use App\Models\Sastav;
use App\Models\ProtivnickiIgrac;
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
            
            // Dohvatamo regularne izmene
            $izmene = Izmena::where('utakmica_id', $utakmica_id)
                ->with(['tim', 'igracOut', 'igracIn'])
                ->orderBy('minut')
                ->get();
                
            // Dohvatamo protivničke izmene
            $protivnickeIzmene = ProtivnickaIzmena::where('utakmica_id', $utakmica_id)
                ->with(['tim', 'igracOut', 'igracIn'])
                ->orderBy('minut')
                ->get();
                
            // Spajamo obe kolekcije izmena
            $sveIzmene = $izmene->concat($protivnickeIzmene)
                ->sortBy('minut');
                
            return view('izmene.index', compact('utakmica', 'sveIzmene'));
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
        
        // Dobavi glavni tim za proveru
        $glavniTim = Tim::glavniTim()->first();
        $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
        $isNasTim = in_array($tim_id, $glavniTimIds);
        
        if ($isNasTim) {
            // Za naš tim, igrači koji izlaze su samo oni u sastavu za ovu utakmicu
            $igraciKojiIzlaze = Sastav::where('utakmica_id', $utakmica_id)
                ->where('tim_id', $tim_id)
                ->with(['igrac' => function($query) {
                    $query->orderBy('prezime')->orderBy('ime');
                }])
                ->get()
                ->pluck('igrac');
            
            // Svi igrači našeg tima (za ulazak)
            $igraciKojiUlaze = Igrac::whereIn('tim_id', $glavniTimIds)
                ->orderBy('prezime')
                ->orderBy('ime')
                ->get();
        } else {
            // Za protivnički tim, samo igrači u sastavu (sa u_sastavu = true)
            $igraciKojiIzlaze = ProtivnickiIgrac::where('utakmica_id', $utakmica_id)
                ->where('tim_id', $tim_id)
                ->where('u_sastavu', true)
                ->orderBy('prezime')
                ->orderBy('ime')
                ->get();
            
            // Za protivničke timove, ne trebaju nam igrači koji ulaze jer će biti uneti kao tekst
            $igraciKojiUlaze = collect();
        }
        
        return view('izmene.create', compact('utakmica', 'tim', 'igraciKojiIzlaze', 'igraciKojiUlaze', 'isNasTim'));
    }

    /**
     * Čuvanje nove izmene.
     */
    public function store(Request $request)
    {
        $tipIzmene = $request->input('tip_izmene');
        
        if ($tipIzmene == 'regularna') {
            // Validacija za naš tim
            $validated = $request->validate([
                'utakmica_id' => 'required|exists:utakmice,id',
                'tim_id' => 'required|exists:timovi,id',
                'igrac_out_id' => 'required|exists:igraci,id',
                'igrac_in_id' => 'required|exists:igraci,id|different:igrac_out_id',
                'minut' => 'required|integer|min:1|max:120',
            ]);
            
            // Dobavimo glavni tim i njegove alijase radi provere
            $glavniTim = Tim::glavniTim()->first();
            $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
            
            // Kreiranje izmene za naš tim
            Izmena::create($validated);
            
            // Ako je izmena za igrača našeg tima, dodajemo ga u sastav
            if (in_array($validated['tim_id'], $glavniTimIds)) {
                // Proveravamo da li je igrač već u sastavu za ovu utakmicu
                $postojeciSastav = Sastav::where('utakmica_id', $validated['utakmica_id'])
                    ->where('tim_id', $validated['tim_id'])
                    ->where('igrac_id', $validated['igrac_in_id'])
                    ->first();
                    
                // Ako nije, dodajemo ga u sastav kao rezervu (starter = false)
                if (!$postojeciSastav) {
                    Sastav::create([
                        'utakmica_id' => $validated['utakmica_id'],
                        'tim_id' => $validated['tim_id'],
                        'igrac_id' => $validated['igrac_in_id'],
                        'starter' => false
                    ]);
                }
            }
        } else {
            // Validacija za protivnički tim
            $validated = $request->validate([
                'utakmica_id' => 'required|exists:utakmice,id',
                'tim_id' => 'required|exists:timovi,id',
                'igrac_out_id' => 'required|exists:protivnicki_igraci,id',
                'igrac_in_ime_prezime' => 'required|string|max:255',
                'minut' => 'required|integer|min:1|max:120',
                'napomena' => 'nullable|string',
            ]);
            
            // Razdvajanje imena i prezimena za igrača koji ulazi
            $imePrezime = explode(' ', $validated['igrac_in_ime_prezime'], 2);
            $ime = $imePrezime[0];
            $prezime = $imePrezime[1] ?? '';
            
            // Kreiraj novog protivničkog igrača koji ulazi
            $protivnickiIgracIn = ProtivnickiIgrac::create([
                'ime' => $ime,
                'prezime' => $prezime,
                'utakmica_id' => $validated['utakmica_id'],
                'tim_id' => $validated['tim_id'],
                'kapiten' => false,
                'u_sastavu' => false
            ]);
            
            // Kreiranje izmene za protivnički tim
            ProtivnickaIzmena::create([
                'utakmica_id' => $validated['utakmica_id'],
                'tim_id' => $validated['tim_id'],
                'igrac_out_id' => $validated['igrac_out_id'],
                'igrac_in_id' => $protivnickiIgracIn->id,
                'minut' => $validated['minut'],
                'napomena' => $validated['napomena'] ?? null,
            ]);
        }

        return redirect()->route('utakmice.show', $request->input('utakmica_id'))
            ->with('success', 'Izmena uspešno zabeležena.');
    }

    /**
     * Prikaz pojedinačne izmene.
     */
    public function show($id)
    {
        // Proveriti da li je obična ili protivnička izmena
        $izmena = Izmena::with(['utakmica', 'tim', 'igracOut', 'igracIn'])->find($id);
        
        if (!$izmena) {
            // Ako nije obična izmena, proveriti da li je protivnička
            $izmena = ProtivnickaIzmena::with(['utakmica', 'tim', 'igracOut', 'igracIn'])->findOrFail($id);
            $tipIzmene = 'protivnicka';
        } else {
            $tipIzmene = 'regularna';
        }
        
        return view('izmene.show', compact('izmena', 'tipIzmene'));
    }

    /**
     * Prikaz forme za izmenu izmene.
     */
    public function edit($id)
    {
        // Proveriti da li je obična ili protivnička izmena
        $izmena = Izmena::with(['utakmica.domacin', 'utakmica.gost', 'tim', 'igracOut', 'igracIn'])->find($id);
        
        if (!$izmena) {
            // Ako nije obična izmena, proveriti da li je protivnička
            $izmena = ProtivnickaIzmena::with(['utakmica.domacin', 'utakmica.gost', 'tim', 'igracOut', 'igracIn'])->findOrFail($id);
            $tipIzmene = 'protivnicka';
            
            // Dobavi glavni tim za proveru
            $glavniTim = Tim::glavniTim()->first();
            $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
            
            // Dohvatanje svih protivničkih igrača za ovaj tim na utakmici
            $igraci = ProtivnickiIgrac::where('utakmica_id', $izmena->utakmica_id)
                    ->where('tim_id', $izmena->tim_id)
                    ->orderBy('prezime')
                    ->orderBy('ime')
                    ->get();
        } else {
            $tipIzmene = 'regularna';
            
            // Dobavi glavni tim za proveru
            $glavniTim = Tim::glavniTim()->first();
            $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
            
            // Za naš tim, dohvati sve igrače repke (ne samo sastav za tu utakmicu)
            $igraci = Igrac::whereIn('tim_id', $glavniTimIds)
                    ->orderBy('prezime')
                    ->orderBy('ime')
                    ->get();
        }
        
        return view('izmene.edit', compact('izmena', 'igraci', 'tipIzmene'));
    }

    /**
     * Ažuriranje izmene.
     */
    public function update(Request $request, $id)
    {
        $tipIzmene = $request->input('tip_izmene');
        
        if ($tipIzmene == 'regularna') {
            // Validacija za naš tim
            $validated = $request->validate([
                'igrac_out_id' => 'required|exists:igraci,id',
                'igrac_in_id' => 'required|exists:igraci,id|different:igrac_out_id',
                'minut' => 'required|integer|min:1|max:120',
            ]);
            
            // Pronalaženje izmene za naš tim
            $izmena = Izmena::findOrFail($id);
            $utakmica_id = $izmena->utakmica_id;
            $tim_id = $izmena->tim_id;
            
            // Ako se menja igrač koji ulazi, ažuriramo sastav
            if ($izmena->igrac_in_id != $validated['igrac_in_id']) {
                // Proveravamo da li stari igrač (koji je ulazio) već ima zapis u sastavu
                $stariIgracSastav = Sastav::where('utakmica_id', $utakmica_id)
                    ->where('tim_id', $tim_id)
                    ->where('igrac_id', $izmena->igrac_in_id)
                    ->first();
                
                // Ako ima zapis u sastavu i samo je kao rezerva (nije starter), uklanjamo ga
                if ($stariIgracSastav && !$stariIgracSastav->starter) {
                    $stariIgracSastav->delete();
                }
                
                // Proveravamo da li novi igrač već ima zapis u sastavu
                $noviIgracSastav = Sastav::where('utakmica_id', $utakmica_id)
                    ->where('tim_id', $tim_id)
                    ->where('igrac_id', $validated['igrac_in_id'])
                    ->first();
                
                // Ako nema zapis u sastavu, dodajemo ga kao rezervu
                if (!$noviIgracSastav) {
                    Sastav::create([
                        'utakmica_id' => $utakmica_id,
                        'tim_id' => $tim_id,
                        'igrac_id' => $validated['igrac_in_id'],
                        'starter' => false
                    ]);
                }
            }
            
            // Ažuriranje izmene
            $izmena->update($validated);
        } else {
            // Validacija za protivnički tim
            $validated = $request->validate([
                'igrac_out_id' => 'required|exists:protivnicki_igraci,id',
                'igrac_in_id' => 'required|exists:protivnicki_igraci,id|different:igrac_out_id',
                'minut' => 'required|integer|min:1|max:120',
                'napomena' => 'nullable|string',
            ]);
            
            // Pronalaženje i ažuriranje izmene za protivnički tim
            $izmena = ProtivnickaIzmena::findOrFail($id);
            $utakmica_id = $izmena->utakmica_id;
            $tim_id = $izmena->tim_id;
            
            // Ako se menja igrač koji ulazi, ažuriramo status u_sastavu
            if ($izmena->igrac_in_id != $validated['igrac_in_id']) {
                // Stari igrač koji ulazi više nije u sastavu
                $stariIgrac = ProtivnickiIgrac::find($izmena->igrac_in_id);
                if ($stariIgrac) {
                    $stariIgrac->update(['u_sastavu' => false]);
                }
                
                // Novi igrač koji ulazi dodajemo u sastav
                $noviIgrac = ProtivnickiIgrac::find($validated['igrac_in_id']);
                if ($noviIgrac) {
                    $noviIgrac->update(['u_sastavu' => true]);
                }
            }
            
            // Ažuriranje izmene
            $izmena->update($validated);
        }

        return redirect()->route('izmene.index', ['utakmica_id' => $izmena->utakmica_id])
            ->with('success', 'Izmena uspešno ažurirana.');
    }

    /**
     * Brisanje izmene.
     */
    public function destroy($id)
    {
        // Prvo proveriti da li je to regularna izmena
        $izmena = Izmena::find($id);
        $utakmica_id = null;
        
        if ($izmena) {
            // Ako je regularna izmena
            $utakmica_id = $izmena->utakmica_id;
            $izmena->delete();
        } else {
            // Ako nije regularna, proveriti da li je protivnička izmena
            $protivnickaIzmena = ProtivnickaIzmena::find($id);
            
            if ($protivnickaIzmena) {
                $utakmica_id = $protivnickaIzmena->utakmica_id;
                
                // Možemo opciono obrisati i igrača koji je ušao kao zamena, ako nije korišćen u drugim izmenama
                $igracInId = $protivnickaIzmena->igrac_in_id;
                $protivnickaIzmena->delete();
                
                // Provera da li igrač koji je ušao ima još izmena
                $imaJosIzmena = ProtivnickaIzmena::where('igrac_in_id', $igracInId)
                    ->orWhere('igrac_out_id', $igracInId)
                    ->exists();
                    
                // Ako nema drugih izmena, obrišimo i igrača
                if (!$imaJosIzmena) {
                    ProtivnickiIgrac::find($igracInId)->delete();
                }
            }
        }
        
        if ($utakmica_id) {
            // Redirektuj na stranicu utakmice umesto na index izmena
            return redirect()->route('utakmice.show', $utakmica_id)
                ->with('success', 'Izmena uspešno obrisana.');
        } else {
            return redirect()->route('utakmice.index')
                ->with('error', 'Izmena nije pronađena.');
        }
    }
}