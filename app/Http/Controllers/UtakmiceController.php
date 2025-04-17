<?php

namespace App\Http\Controllers;

use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Takmicenje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtakmiceController extends Controller
{

   /**
    * Prikaz svih utakmica.
    */
   public function index()
   {
       $utakmice = Utakmica::with(['domacin', 'gost'])
           ->orderBy('datum', 'desc')
           ->paginate(25);
       return view('utakmice.index', compact('utakmice'));
   }

   /**
    * Prikaz forme za kreiranje utakmice.
    */
   public function create()
   {
       if (auth()->user() && auth()->user()->hasEditAccess()) {
            $timovi = \App\Models\Tim::orderBy('naziv')->get();
            return view('utakmice.create', compact('timovi'));
        }
        
        abort(403, 'Unauthorized action.');
   }

    /**
     * Čuvanje nove utakmice.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'datum' => 'required|date',
            'vreme' => 'nullable|string|max:5', // Format: 20:45
            'takmicenje' => 'required|string|max:255',
            'domacin_id' => 'required|exists:timovi,id',
            'gost_id' => 'required|exists:timovi,id|different:domacin_id',
            'stadion' => 'nullable|string|max:255',
            'sudija' => 'nullable|string|max:255',
            'publika' => 'nullable|string|max:255',
            'imao_jedanaesterce' => 'nullable', // Changed from boolean to nullable
            'jedanaesterci_domacin' => 'nullable|integer|min:0',
            'jedanaesterci_gost' => 'nullable|integer|min:0',
        ]);

        // Create or find the competition
        $takmicenje = Takmicenje::firstOrCreate(
            ['naziv' => $validated['takmicenje']],
            ['organizator' => null]
        );

        // Prepare data for creating the match
        $utakmicaData = [
            'datum' => $validated['datum'],
            'vreme' => $validated['vreme'] ?? null,
            'takmicenje_id' => $takmicenje->id,
            'domacin_id' => $validated['domacin_id'],
            'gost_id' => $validated['gost_id'],
            'stadion' => $validated['stadion'] ?? null,
            'sudija' => $validated['sudija'] ?? null,
            'publika' => $validated['publika'] ?? null,
            'rezultat_domacin' => 0,
            'rezultat_gost' => 0,
            'imao_jedanaesterce' => $request->has('imao_jedanaesterce'),
        ];

        // Add penalty shootout data if present
        if ($request->has('imao_jedanaesterce')) {
            $utakmicaData['jedanaesterci_domacin'] = $validated['jedanaesterci_domacin'] ?? 0;
            $utakmicaData['jedanaesterci_gost'] = $validated['jedanaesterci_gost'] ?? 0;
        }

        // Use transaction to ensure all related data is saved successfully
        DB::transaction(function() use ($utakmicaData) {
            Utakmica::create($utakmicaData);
        });

        return redirect()->route('utakmice.index')
            ->with('success', 'Utakmica uspešno kreirana.');
    }

    /**
     * Ažuriranje utakmice.
     */
    public function update(Request $request, Utakmica $utakmica)
    {
        $validated = $request->validate([
            'datum' => 'required|date',
            'vreme' => 'nullable|string|max:5', // Format: 20:45
            'takmicenje' => 'required|string|max:255',
            'domacin_id' => 'required|exists:timovi,id',
            'gost_id' => 'required|exists:timovi,id|different:domacin_id',
            'stadion' => 'nullable|string|max:255',
            'sudija' => 'nullable|string|max:255',
            'publika' => 'nullable|string|max:255',
            'imao_jedanaesterce' => 'nullable', // Changed from boolean to nullable
            'jedanaesterci_domacin' => 'nullable|integer|min:0',
            'jedanaesterci_gost' => 'nullable|integer|min:0',
        ]);

        // Create or find the competition
        $takmicenje = Takmicenje::firstOrCreate(
            ['naziv' => $validated['takmicenje']],
            ['organizator' => null]
        );

        // Prepare data for updating the match
        $utakmicaData = [
            'datum' => $validated['datum'],
            'vreme' => $validated['vreme'] ?? null,
            'takmicenje_id' => $takmicenje->id,
            'domacin_id' => $validated['domacin_id'],
            'gost_id' => $validated['gost_id'],
            'stadion' => $validated['stadion'] ?? null,
            'sudija' => $validated['sudija'] ?? null,
            'publika' => $validated['publika'] ?? null,
            'imao_jedanaesterce' => $request->has('imao_jedanaesterce'),
        ];

        // Add penalty shootout data if present
        if ($request->has('imao_jedanaesterce')) {
            $utakmicaData['jedanaesterci_domacin'] = $validated['jedanaesterci_domacin'] ?? 0;
            $utakmicaData['jedanaesterci_gost'] = $validated['jedanaesterci_gost'] ?? 0;
        } else {
            $utakmicaData['jedanaesterci_domacin'] = null;
            $utakmicaData['jedanaesterci_gost'] = null;
        }

        $utakmica->update($utakmicaData);

        return redirect()->route('utakmice.index')
            ->with('success', 'Utakmica uspešno ažurirana.');
    }

   /**
    * Prikaz pojedinog detalja utakmice.
    */
    public function show($id)
    {
        $utakmica = Utakmica::with([
            'domacin', 
            'gost', 
            'sastavi' => function($query) {
                $query->orderBy('redosled')->orderBy('starter', 'desc');
            },
            'sastavi.igrac', 
            'golovi.igrac', 
            'izmene.igracOut', 
            'izmene.igracIn', 
            'kartoni.igrac',
            'protivnickiIgraci' => function($query) {
                $query->orderBy('redosled')->orderBy('prezime');
            }
        ])->findOrFail($id);
    
        $selektor = $utakmica->nasSelector();
        
        return view('utakmice.show', compact('utakmica', 'selektor'));
    }

   /**
    * Prikaz forme za izmenu utakmice.
    */
   public function edit(Utakmica $utakmica)
   {
       $timovi = Tim::orderBy('naziv')->get();
       $takmicenja = Takmicenje::orderBy('naziv')->get();
       
       return view('utakmice.edit', compact('utakmica', 'timovi', 'takmicenja'));
   }

   /**
    * Brisanje utakmice.
    */
   public function destroy(Utakmica $utakmica)
   {
       try {
           $utakmica->delete();
           return redirect()->route('utakmice.index')
               ->with('success', 'Utakmica uspešno obrisana.');
       } catch (\Exception $e) {
           return redirect()->route('utakmice.index')
               ->with('error', 'Utakmicu nije moguće obrisati jer se koristi u drugim tabelama.');
       }
   }

   /**
    * Ažuriranje rezultata utakmice na osnovu golova.
    * This method can be called separately to recalculate score.
    */
   public function updateScore(Utakmica $utakmica)
   {
       // Count goals for home team
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
           
       // Count goals for away team
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
       
       return $utakmica;
   }

   /**
     * Prikaz utakmica za određenu dekadu.
     * 
     * @param string $dekada Format: 'YYYY-YYYY', npr. '1920-1929'
     * @return \Illuminate\View\View
     */
    public function dekada($dekada)
    {
        list($startYear, $endYear) = explode('-', $dekada);
        
        // Ako je dekada "danas", koristimo trenutnu godinu
        if ($endYear === 'danas') {
            $endYear = date('Y');
        }
        
        $utakmice = Utakmica::with(['domacin', 'gost'])
            ->whereYear('datum', '>=', $startYear)
            ->whereYear('datum', '<=', $endYear)
            ->orderBy('datum', 'desc')
            ->paginate(25);
            
        return view('utakmice.index', compact('utakmice', 'dekada'));
    }
}