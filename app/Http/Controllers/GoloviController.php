<?php

namespace App\Http\Controllers;

use App\Models\Gol;
use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
use App\Models\ProtivnickiIgrac;
use Illuminate\Http\Request;

class GoloviController extends Controller
{
    /**
     * Prikaz golova za određenu utakmicu.
     */
    public function index(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        
        if ($utakmica_id) {
            $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
            
            $golovi = Gol::where('utakmica_id', $utakmica_id)
                ->with(['igrac', 'tim'])
                ->orderBy('minut')
                ->get();
                
            return view('golovi.index', compact('utakmica', 'golovi'));
        }
        
        $utakmice = Utakmica::with(['domacin', 'gost'])
            ->orderBy('datum', 'desc')
            ->paginate(10);
            
        return view('golovi.select_utakmica', compact('utakmice'));
    }

    /**
     * Prikaz forme za dodavanje gola.
     */
    public function create(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        
        if (!$utakmica_id) {
            return redirect()->route('golovi.index')
                ->with('error', 'Morate izabrati utakmicu.');
        }
        
        $utakmica = Utakmica::with(['domacin', 'gost', 'sastavi.igrac'])->findOrFail($utakmica_id);
        $timovi = [$utakmica->domacin, $utakmica->gost];
        
        // Dobavljanje samo igrača koji su u sastavu
        $igraciDomacina = $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)
            ->map(function($sastav) {
                return $sastav->igrac;
            })->sortBy('prezime')->values();
        
        $igraciGosta = $utakmica->sastavi->where('tim_id', $utakmica->gost_id)
            ->map(function($sastav) {
                return $sastav->igrac;
            })->sortBy('prezime')->values();
        
        // Ako nema igrača u sastavima, koristimo standardni pristup
        if ($igraciDomacina->isEmpty()) {
            $igraciDomacina = Igrac::where('tim_id', $utakmica->domacin_id)->orderBy('prezime')->get();
        }
        
        if ($igraciGosta->isEmpty()) {
            $igraciGosta = Igrac::where('tim_id', $utakmica->gost_id)->orderBy('prezime')->get();
        }
        
        // Dobavljanje glavnog tima za proveru
        $glavniTim = Tim::glavniTim()->first();
        $glavniTimId = $glavniTim ? $glavniTim->id : null;
        
        // Dobavljanje protivničkih igrača takođe
        $protivnickiIgraciDomacina = [];
        $protivnickiIgraciGosta = [];
        
        // Ako je domaćin protivnički tim, dohvati njihove igrače iz protivničkih igrača
        if ($utakmica->domacin_id != $glavniTimId) {
            $protivnickiIgraciDomacina = ProtivnickiIgrac::where('utakmica_id', $utakmica_id)
                ->where('tim_id', $utakmica->domacin_id)
                ->get();
            
            // Spoji ih sa regularnim igračima ako ih ima
            if ($protivnickiIgraciDomacina->count() > 0 && $igraciDomacina instanceof \Illuminate\Support\Collection) {
                foreach ($protivnickiIgraciDomacina as $protivnickiIgrac) {
                    // Kreiraj virtualni objekat igrača
                    $virtualniIgrac = new \stdClass();
                    $virtualniIgrac->id = 'pi_' . $protivnickiIgrac->id; // Prefiks za identifikaciju
                    $virtualniIgrac->ime = $protivnickiIgrac->ime;
                    $virtualniIgrac->prezime = $protivnickiIgrac->prezime;
                    $virtualniIgrac->je_protivnicki = true;
                    
                    $igraciDomacina->push($virtualniIgrac);
                }
            }
        }
        
        // Isto za gostujući tim
        if ($utakmica->gost_id != $glavniTimId) {
            $protivnickiIgraciGosta = ProtivnickiIgrac::where('utakmica_id', $utakmica_id)
                ->where('tim_id', $utakmica->gost_id)
                ->get();
            
            // Spoji ih sa regularnim igračima ako ih ima
            if ($protivnickiIgraciGosta->count() > 0 && $igraciGosta instanceof \Illuminate\Support\Collection) {
                foreach ($protivnickiIgraciGosta as $protivnickiIgrac) {
                    // Kreiraj virtualni objekat igrača
                    $virtualniIgrac = new \stdClass();
                    $virtualniIgrac->id = 'pi_' . $protivnickiIgrac->id; // Prefiks za identifikaciju
                    $virtualniIgrac->ime = $protivnickiIgrac->ime;
                    $virtualniIgrac->prezime = $protivnickiIgrac->prezime;
                    $virtualniIgrac->je_protivnicki = true;
                    
                    $igraciGosta->push($virtualniIgrac);
                }
            }
        }
        
        return view('golovi.create', compact('utakmica', 'timovi', 'igraciDomacina', 'igraciGosta'));
    }

    public function store(Request $request)
    {
        // Provera da li je protivnički igrač
        $igracId = $request->input('igrac_id');
        $isProtivnicki = false;
        
        // Ako ID počinje sa "pi_", to je protivnički igrač
        if (strpos($igracId, 'pi_') === 0) {
            $isProtivnicki = true;
            $igracId = (int)substr($igracId, 3); // Uzimamo samo broj
        }
        
        $validated = $request->validate([
            'utakmica_id' => 'required|exists:utakmice,id',
            'tim_id' => 'required|exists:timovi,id',
            'minut' => 'nullable|integer|min:1|max:120',
        ]);
        
        // Dodajemo obrađene podatke
        $validated['igrac_id'] = $igracId;
        $validated['igrac_tip'] = $isProtivnicki ? 'protivnicki' : 'regularni';
        $validated['penal'] = $request->has('penal');
        $validated['auto_gol'] = $request->has('auto_gol');
        
        // Proveravamo da li ID igrača postoji u odgovarajućoj tabeli
        if ($isProtivnicki) {
            $igracPostoji = ProtivnickiIgrac::where('id', $igracId)
                                        ->where('utakmica_id', $validated['utakmica_id'])
                                        ->exists();
            if (!$igracPostoji) {
                return back()->withErrors(['igrac_id' => 'Izabrani protivnički igrač ne postoji.'])
                            ->withInput();
            }
        } else {
            $igracPostoji = Igrac::where('id', $igracId)->exists();
            if (!$igracPostoji) {
                return back()->withErrors(['igrac_id' => 'Izabrani igrač ne postoji.'])
                            ->withInput();
            }
        }
        
        Gol::create($validated);
        
        // Ažuriranje rezultata utakmice
        $this->updateUtakmicaRezultat($validated['utakmica_id']);
        
        return redirect()->route('utakmice.show', $validated['utakmica_id'])
            ->with('success', 'Gol uspešno zabeležen.');
    }

    /**
     * Prikaz pojedinačnog gola.
     */
    public function show(Gol $gol)
    {
        $gol->load(['utakmica', 'tim', 'igrac']);
        return view('golovi.show', compact('gol'));
    }

    /**
     * Prikaz forme za izmenu gola.
     */
    public function edit(Gol $gol)
    {
        $gol->load(['utakmica.domacin', 'utakmica.gost', 'tim', 'igrac']);
        
        $utakmica = $gol->utakmica;
        $timovi = [$utakmica->domacin, $utakmica->gost];
        
        // Dobavljanje igrača koji su u sastavu
        $sastaviDomacina = $utakmica->sastavi()->where('tim_id', $utakmica->domacin_id)->pluck('igrac_id')->toArray();
        $sastaviGosta = $utakmica->sastavi()->where('tim_id', $utakmica->gost_id)->pluck('igrac_id')->toArray();
        
        if (!empty($sastaviDomacina)) {
            $igraciDomacina = Igrac::whereIn('id', $sastaviDomacina)->orderBy('prezime')->get();
        } else {
            $igraciDomacina = Igrac::where('tim_id', $utakmica->domacin_id)->orderBy('prezime')->get();
        }
        
        if (!empty($sastaviGosta)) {
            $igraciGosta = Igrac::whereIn('id', $sastaviGosta)->orderBy('prezime')->get();
        } else {
            $igraciGosta = Igrac::where('tim_id', $utakmica->gost_id)->orderBy('prezime')->get();
        }
        
        // Get opponent players if this is an opponent goal
        if ($gol->igrac_tip === 'protivnicki') {
            // Load opponent players
            $protivnickiIgraci = ProtivnickiIgrac::where('utakmica_id', $utakmica->id)
                                ->where('tim_id', $gol->tim_id)
                                ->get();
                                
            if ($gol->tim_id == $utakmica->domacin_id) {
                foreach ($protivnickiIgraci as $protivnickiIgrac) {
                    $virtualniIgrac = new \stdClass();
                    $virtualniIgrac->id = 'pi_' . $protivnickiIgrac->id;
                    $virtualniIgrac->ime = $protivnickiIgrac->ime;
                    $virtualniIgrac->prezime = $protivnickiIgrac->prezime;
                    $virtualniIgrac->je_protivnicki = true;
                    
                    $igraciDomacina->push($virtualniIgrac);
                }
            } else {
                foreach ($protivnickiIgraci as $protivnickiIgrac) {
                    $virtualniIgrac = new \stdClass();
                    $virtualniIgrac->id = 'pi_' . $protivnickiIgrac->id;
                    $virtualniIgrac->ime = $protivnickiIgrac->ime;
                    $virtualniIgrac->prezime = $protivnickiIgrac->prezime;
                    $virtualniIgrac->je_protivnicki = true;
                    
                    $igraciGosta->push($virtualniIgrac);
                }
            }
        }
        
        // Add current player who scored if they're not in the lineup
        $currentPlayerId = $gol->igrac_id;
        
        if ($gol->igrac_tip === 'regularni') {
            if ($gol->tim_id == $utakmica->domacin_id && !$igraciDomacina->contains('id', $currentPlayerId)) {
                $igraciDomacina->push(Igrac::find($currentPlayerId));
            } elseif ($gol->tim_id == $utakmica->gost_id && !$igraciGosta->contains('id', $currentPlayerId)) {
                $igraciGosta->push(Igrac::find($currentPlayerId));
            }
        }
        
        return view('golovi.edit', compact('gol', 'utakmica', 'timovi', 'igraciDomacina', 'igraciGosta'));
    }

    /**
     * Ažuriranje gola.
     */
    public function update(Request $request, Gol $gol)
    {
        // Check if it's an opponent player
        $igracId = $request->input('igrac_id');
        $isProtivnicki = false;
        
        if (strpos($igracId, 'pi_') === 0) {
            $isProtivnicki = true;
            $igracId = (int)substr($igracId, 3);
        }
        
        $validated = $request->validate([
            'tim_id' => 'required|exists:timovi,id',
            'minut' => 'required|integer|min:1|max:120',
        ]);

        // Set other values
        $validated['igrac_id'] = $igracId;
        $validated['igrac_tip'] = $isProtivnicki ? 'protivnicki' : 'regularni';
        $validated['penal'] = $request->has('penal');
        $validated['auto_gol'] = $request->has('auto_gol');

        $gol->update($validated);

        // Update match score
        $this->updateUtakmicaRezultat($gol->utakmica_id);

        return redirect()->route('utakmice.show', $gol->utakmica_id)
            ->with('success', 'Gol uspešno ažuriran.');
    }

    /**
     * Brisanje gola.
     */
    public function destroy($id)
    {
        try {
            // Find goal by ID manually
            $gol = Gol::findOrFail($id);
            $utakmica_id = $gol->utakmica_id;
            
            // Delete the goal
            $gol->delete();
            
            // Get the match
            $utakmica = Utakmica::findOrFail($utakmica_id);
            
            // Count goals for home team
            $domaciGolovi = Gol::where('utakmica_id', $utakmica_id)
                ->where(function($query) use ($utakmica) {
                    $query->where(function($q) use ($utakmica) {
                        $q->where('tim_id', $utakmica->domacin_id)
                        ->where('auto_gol', false);
                    })->orWhere(function($q) use ($utakmica) {
                        $q->where('tim_id', $utakmica->gost_id)
                        ->where('auto_gol', true);
                    });
                })
                ->count();
                
            // Count goals for away team
            $gostiGolovi = Gol::where('utakmica_id', $utakmica_id)
                ->where(function($query) use ($utakmica) {
                    $query->where(function($q) use ($utakmica) {
                        $q->where('tim_id', $utakmica->gost_id)
                        ->where('auto_gol', false);
                    })->orWhere(function($q) use ($utakmica) {
                        $q->where('tim_id', $utakmica->domacin_id)
                        ->where('auto_gol', true);
                    });
                })
                ->count();
                
            // Update match result
            $utakmica->rezultat_domacin = $domaciGolovi;
            $utakmica->rezultat_gost = $gostiGolovi;
            $utakmica->save();
            
            return redirect()->route('utakmice.show', $utakmica_id)
                ->with('success', 'Gol uspešno obrisan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Greška prilikom brisanja gola: ' . $e->getMessage());
        }
    }

    /**
     * Ažuriranje rezultata utakmice na osnovu golova.
     */
    private function updateUtakmicaRezultat($utakmica_id)
    {
        $utakmica = Utakmica::findOrFail($utakmica_id);
        
        // Brojanje golova domaćina
        $domaciGolovi = Gol::where('utakmica_id', $utakmica_id)
            ->where(function($query) use ($utakmica) {
                $query->where(function($q) use ($utakmica) {
                    $q->where('tim_id', $utakmica->domacin_id)
                    ->where('auto_gol', false);
                })->orWhere(function($q) use ($utakmica) {
                    $q->where('tim_id', $utakmica->gost_id)
                    ->where('auto_gol', true);
                });
            })
            ->count();
            
        // Brojanje golova gosta
        $gostiGolovi = Gol::where('utakmica_id', $utakmica_id)
            ->where(function($query) use ($utakmica) {
                $query->where(function($q) use ($utakmica) {
                    $q->where('tim_id', $utakmica->gost_id)
                    ->where('auto_gol', false);
                })->orWhere(function($q) use ($utakmica) {
                    $q->where('tim_id', $utakmica->domacin_id)
                    ->where('auto_gol', true);
                });
            })
            ->count();
            
        // Ažuriranje rezultata
        $utakmica->rezultat_domacin = $domaciGolovi;
        $utakmica->rezultat_gost = $gostiGolovi;
        $utakmica->save();
        
        return $utakmica;
    }
}