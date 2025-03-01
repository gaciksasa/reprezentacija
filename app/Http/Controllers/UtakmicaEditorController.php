<?php

namespace App\Http\Controllers;

use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
use App\Models\Sastav;
use App\Models\Gol;
use App\Models\Izmena;
use App\Models\Karton;
use App\Models\Takmicenje;
use App\Models\Stadion;
use App\Models\Sudija;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtakmicaEditorController extends Controller
{
    /**
     * Show the form for editing a match and all related data
     */
    public function edit(Utakmica $utakmica)
    {
        // Load all related data for the match
        $utakmica->load([
            'domacin', 'gost', 'takmicenje', 'stadion', 'sudija',
            'sastavi.igrac', 'golovi.igrac', 'izmene', 'kartoni'
        ]);
        
        // Get data for dropdowns
        $timovi = Tim::orderBy('naziv')->get();
        $takmicenja = Takmicenje::orderBy('naziv')->get();
        $stadioni = Stadion::orderBy('naziv')->get();
        $sudije = Sudija::orderBy('prezime')->get();
        
        // Get players from both teams
        $igraciDomacina = Igrac::where('tim_id', $utakmica->domacin_id)->orderBy('prezime')->get();
        $igraciGosta = Igrac::where('tim_id', $utakmica->gost_id)->orderBy('prezime')->get();
        
        return view('utakmice.editor', compact(
            'utakmica', 'timovi', 'takmicenja', 'stadioni', 'sudije',
            'igraciDomacina', 'igraciGosta'
        ));
    }
    
    /**
     * Create a new match with the unified editor
     */
    public function create()
    {
        $timovi = Tim::orderBy('naziv')->get();
        $takmicenja = Takmicenje::orderBy('naziv')->get();
        $stadioni = Stadion::orderBy('naziv')->get();
        $sudije = Sudija::orderBy('prezime')->get();
        
        return view('utakmice.create_unified', compact('timovi', 'takmicenja', 'stadioni', 'sudije'));
    }
    
    /**
     * Store a new match with all related data
     */
    public function store(Request $request)
    {
        // Validate the basic match data
        $validated = $request->validate([
            'datum' => 'required|date',
            'vreme' => 'nullable|date_format:H:i',
            'takmicenje_id' => 'required|exists:takmicenja,id',
            'domacin_id' => 'required|exists:timovi,id',
            'gost_id' => 'required|exists:timovi,id|different:domacin_id',
            'stadion_id' => 'nullable|exists:stadioni,id',
            'rezultat_domacin' => 'nullable|integer|min:0',
            'rezultat_gost' => 'nullable|integer|min:0',
            'poluvreme_rezultat_domacin' => 'nullable|integer|min:0',
            'poluvreme_rezultat_gost' => 'nullable|integer|min:0',
            'sudija_id' => 'nullable|exists:sudije,id',
            'publika' => 'nullable|string|max:255',
            'sezona' => 'nullable|string|max:50',
        ]);
        
        // Use transaction to ensure all data is saved or none
        return DB::transaction(function() use ($request, $validated) {
            // Create the match
            $utakmica = Utakmica::create($validated);
            
            // Process lineups if provided
            if ($request->has('sastavi')) {
                $this->processSastavi($utakmica, $request->input('sastavi'));
            }
            
            // Process goals if provided
            if ($request->has('golovi')) {
                $this->processGolovi($utakmica, $request->input('golovi'));
            }
            
            // Process substitutions if provided
            if ($request->has('izmene')) {
                $this->processIzmene($utakmica, $request->input('izmene'));
            }
            
            // Process cards if provided
            if ($request->has('kartoni')) {
                $this->processKartoni($utakmica, $request->input('kartoni'));
            }
            
            return redirect()->route('utakmice.show', $utakmica)
                ->with('success', 'Utakmica je uspešno kreirana sa svim podacima.');
        });
    }
    
    /**
     * Update a match and all related data
     */
    public function update(Request $request, Utakmica $utakmica)
    {
        // Validate the basic match data
        $validated = $request->validate([
            'datum' => 'required|date',
            'vreme' => 'nullable|date_format:H:i',
            'takmicenje_id' => 'required|exists:takmicenja,id',
            'domacin_id' => 'required|exists:timovi,id',
            'gost_id' => 'required|exists:timovi,id|different:domacin_id',
            'stadion_id' => 'nullable|exists:stadioni,id',
            'rezultat_domacin' => 'nullable|integer|min:0',
            'rezultat_gost' => 'nullable|integer|min:0',
            'poluvreme_rezultat_domacin' => 'nullable|integer|min:0',
            'poluvreme_rezultat_gost' => 'nullable|integer|min:0',
            'sudija_id' => 'nullable|exists:sudije,id',
            'publika' => 'nullable|string|max:255',
            'sezona' => 'nullable|string|max:50',
        ]);
        
        // Use transaction to ensure all data is saved or none
        return DB::transaction(function() use ($request, $utakmica, $validated) {
            // Update the match
            $utakmica->update($validated);
            
            // Update lineups - first delete existing, then add new ones
            if ($request->has('sastavi')) {
                Sastav::where('utakmica_id', $utakmica->id)->delete();
                $this->processSastavi($utakmica, $request->input('sastavi'));
            }
            
            // Update goals - first delete existing, then add new ones
            if ($request->has('golovi')) {
                Gol::where('utakmica_id', $utakmica->id)->delete();
                $this->processGolovi($utakmica, $request->input('golovi'));
            }
            
            // Update substitutions - first delete existing, then add new ones
            if ($request->has('izmene')) {
                Izmena::where('utakmica_id', $utakmica->id)->delete();
                $this->processIzmene($utakmica, $request->input('izmene'));
            }
            
            // Update cards - first delete existing, then add new ones
            if ($request->has('kartoni')) {
                Karton::where('utakmica_id', $utakmica->id)->delete();
                $this->processKartoni($utakmica, $request->input('kartoni'));
            }
            
            return redirect()->route('utakmice.show', $utakmica)
                ->with('success', 'Utakmica je uspešno ažurirana sa svim podacima.');
        });
    }
    
    /**
     * Process lineup data
     */
    private function processSastavi(Utakmica $utakmica, array $sastavi)
    {
        foreach ($sastavi as $sastav) {
            if (isset($sastav['igrac_id']) && $sastav['igrac_id']) {
                Sastav::create([
                    'utakmica_id' => $utakmica->id,
                    'tim_id' => $sastav['tim_id'],
                    'igrac_id' => $sastav['igrac_id'],
                    'starter' => $sastav['starter'] ?? false,
                    'selektor' => $sastav['selektor'] ?? null,
                ]);
            }
        }
    }
    
    /**
     * Process goals data
     */
    private function processGolovi(Utakmica $utakmica, array $golovi)
    {
        foreach ($golovi as $gol) {
            if (isset($gol['igrac_id']) && $gol['igrac_id']) {
                Gol::create([
                    'utakmica_id' => $utakmica->id,
                    'igrac_id' => $gol['igrac_id'],
                    'tim_id' => $gol['tim_id'],
                    'minut' => $gol['minut'],
                    'penal' => $gol['penal'] ?? false,
                    'auto_gol' => $gol['auto_gol'] ?? false,
                ]);
            }
        }
        
        // Update match result based on goals
        $this->updateUtakmicaRezultat($utakmica);
    }
    
    /**
     * Process substitutions data
     */
    private function processIzmene(Utakmica $utakmica, array $izmene)
    {
        foreach ($izmene as $izmena) {
            if (isset($izmena['igrac_out_id']) && $izmena['igrac_out_id'] && 
                isset($izmena['igrac_in_id']) && $izmena['igrac_in_id']) {
                Izmena::create([
                    'utakmica_id' => $utakmica->id,
                    'tim_id' => $izmena['tim_id'],
                    'igrac_out_id' => $izmena['igrac_out_id'],
                    'igrac_in_id' => $izmena['igrac_in_id'],
                    'minut' => $izmena['minut'],
                ]);
            }
        }
    }
    
    /**
     * Process cards data
     */
    private function processKartoni(Utakmica $utakmica, array $kartoni)
    {
        foreach ($kartoni as $karton) {
            if (isset($karton['igrac_id']) && $karton['igrac_id']) {
                Karton::create([
                    'utakmica_id' => $utakmica->id,
                    'igrac_id' => $karton['igrac_id'],
                    'tim_id' => $karton['tim_id'],
                    'tip' => $karton['tip'],
                    'minut' => $karton['minut'],
                ]);
            }
        }
    }
    
    /**
     * Update match result based on goals
     */
    private function updateUtakmicaRezultat(Utakmica $utakmica)
    {
        // Counting home team goals
        $domaciGolovi = Gol::where('utakmica_id', $utakmica->id)
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
            
        // Counting away team goals
        $gostiGolovi = Gol::where('utakmica_id', $utakmica->id)
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
            
        // Update result
        $utakmica->rezultat_domacin = $domaciGolovi;
        $utakmica->rezultat_gost = $gostiGolovi;
        $utakmica->save();
    }
    
    /**
     * Load players for the selected teams via AJAX
     */
    public function ucitajIgrace(Request $request)
    {
        $domacin_id = $request->input('domacin_id');
        $gost_id = $request->input('gost_id');
        
        $igraciDomacina = [];
        $igraciGosta = [];
        
        if ($domacin_id) {
            $igraciDomacina = Igrac::where('tim_id', $domacin_id)
                ->orderBy('prezime')
                ->get(['id', 'ime', 'prezime', 'broj_dresa']);
        }
        
        if ($gost_id) {
            $igraciGosta = Igrac::where('tim_id', $gost_id)
                ->orderBy('prezime')
                ->get(['id', 'ime', 'prezime', 'broj_dresa']);
        }
        
        return response()->json([
            'domacin' => $igraciDomacina,
            'gost' => $igraciGosta
        ]);
    }
}