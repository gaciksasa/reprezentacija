<?php

namespace App\Http\Controllers;

use App\Models\Gol;
use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
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
        
        $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
        $timovi = [$utakmica->domacin, $utakmica->gost];
        
        // Igrači oba tima koji su u sastavu ove utakmice
        $igraciDomacina = Igrac::where('tim_id', $utakmica->domacin_id)->orderBy('prezime')->get();
        $igraciGosta = Igrac::where('tim_id', $utakmica->gost_id)->orderBy('prezime')->get();
        
        return view('golovi.create', compact('utakmica', 'timovi', 'igraciDomacina', 'igraciGosta'));
    }

    /**
     * Čuvanje novog gola.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'utakmica_id' => 'required|exists:utakmice,id',
            'igrac_id' => 'required|exists:igraci,id',
            'tim_id' => 'required|exists:timovi,id',
            'minut' => 'required|integer|min:1|max:120',
            'penal' => 'boolean',
            'auto_gol' => 'boolean',
        ]);

        // Postavljanje podrazumevanih vrednosti
        $validated['penal'] = $request->has('penal');
        $validated['auto_gol'] = $request->has('auto_gol');

        Gol::create($validated);

        // Ažuriranje rezultata utakmice
        $this->updateUtakmicaRezultat($validated['utakmica_id']);

        return redirect()->route('golovi.index', ['utakmica_id' => $validated['utakmica_id']])
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
        
        $igraciDomacina = Igrac::where('tim_id', $utakmica->domacin_id)->orderBy('prezime')->get();
        $igraciGosta = Igrac::where('tim_id', $utakmica->gost_id)->orderBy('prezime')->get();
        
        return view('golovi.edit', compact('gol', 'utakmica', 'timovi', 'igraciDomacina', 'igraciGosta'));
    }

    /**
     * Ažuriranje gola.
     */
    public function update(Request $request, Gol $gol)
    {
        $validated = $request->validate([
            'igrac_id' => 'required|exists:igraci,id',
            'tim_id' => 'required|exists:timovi,id',
            'minut' => 'required|integer|min:1|max:120',
            'penal' => 'boolean',
            'auto_gol' => 'boolean',
        ]);

        // Postavljanje podrazumevanih vrednosti
        $validated['penal'] = $request->has('penal');
        $validated['auto_gol'] = $request->has('auto_gol');

        $gol->update($validated);

        // Ažuriranje rezultata utakmice
        $this->updateUtakmicaRezultat($gol->utakmica_id);

        return redirect()->route('golovi.index', ['utakmica_id' => $gol->utakmica_id])
            ->with('success', 'Gol uspešno ažuriran.');
    }

    /**
     * Brisanje gola.
     */
    public function destroy(Gol $gol)
    {
        $utakmica_id = $gol->utakmica_id;
        $gol->delete();
        
        // Ažuriranje rezultata utakmice
        $this->updateUtakmicaRezultat($utakmica_id);
        
        return redirect()->route('golovi.index', ['utakmica_id' => $utakmica_id])
            ->with('success', 'Gol uspešno obrisan.');
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
    }
}