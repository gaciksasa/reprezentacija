<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
use App\Models\Takmicenje;
use App\Models\Gol;
use App\Models\Karton;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Prikaz početne stranice sa statistikom.
     */
    public function index()
    {
        // Poslednje odigrane utakmice
        $poslednjeUtakmice = Utakmica::with(['domacin', 'gost', 'takmicenje'])
            ->orderBy('datum', 'desc')
            ->take(5)
            ->get();
            
        // Ukupan broj timova, igrača i utakmica
        $brojTimova = Tim::count();
        $brojIgraca = Igrac::count();
        $brojUtakmica = Utakmica::count();
        
        // Najbolji strelci
        $strelci = Igrac::select('igraci.id', 'igraci.ime', 'igraci.prezime', 'timovi.naziv as tim',
                           DB::raw('COUNT(golovi.id) as broj_golova'))
                  ->join('golovi', 'igraci.id', '=', 'golovi.igrac_id')
                  ->join('timovi', 'igraci.tim_id', '=', 'timovi.id')
                  ->where('golovi.auto_gol', false)
                  ->groupBy('igraci.id', 'igraci.ime', 'igraci.prezime', 'timovi.naziv')
                  ->orderBy('broj_golova', 'desc')
                  ->take(10)
                  ->get();
                  
        // Najbolji timovi po broju pobeda
        $timoviBrojPobeda = Tim::select('timovi.id', 'timovi.naziv',
                           DB::raw('COUNT(CASE WHEN utakmice.domacin_id = timovi.id AND utakmice.rezultat_domacin > utakmice.rezultat_gost THEN 1
                                        WHEN utakmice.gost_id = timovi.id AND utakmice.rezultat_gost > utakmice.rezultat_domacin THEN 1
                                        ELSE NULL END) as broj_pobeda'))
                  ->leftJoin('utakmice', function($join) {
                      $join->on('timovi.id', '=', 'utakmice.domacin_id')
                           ->orOn('timovi.id', '=', 'utakmice.gost_id');
                  })
                  ->groupBy('timovi.id', 'timovi.naziv')
                  ->orderBy('broj_pobeda', 'desc')
                  ->take(5)
                  ->get();
                  
        // Igrači sa najviše kartona
        $igraciKartoni = Igrac::select('igraci.id', 'igraci.ime', 'igraci.prezime', 'timovi.naziv as tim',
                           DB::raw('COUNT(CASE WHEN kartoni.tip = "zuti" THEN 1 ELSE NULL END) as zuti_kartoni'),
                           DB::raw('COUNT(CASE WHEN kartoni.tip = "crveni" THEN 1 ELSE NULL END) as crveni_kartoni'))
                  ->join('kartoni', 'igraci.id', '=', 'kartoni.igrac_id')
                  ->join('timovi', 'igraci.tim_id', '=', 'timovi.id')
                  ->groupBy('igraci.id', 'igraci.ime', 'igraci.prezime', 'timovi.naziv')
                  ->orderBy('zuti_kartoni', 'desc')
                  ->orderBy('crveni_kartoni', 'desc')
                  ->take(10)
                  ->get();
                  
        return view('dashboard', compact(
            'poslednjeUtakmice', 
            'brojTimova', 
            'brojIgraca', 
            'brojUtakmica',
            'strelci',
            'timoviBrojPobeda',
            'igraciKartoni'
        ));
    }
    
    /**
     * Prikaz statistike utakmica.
     */
    public function statistika()
    {
        // Takmičenja sa brojem utakmica
        $takmicenjaBrojUtakmica = Takmicenje::select('takmicenja.id', 'takmicenja.naziv',
                                  DB::raw('COUNT(utakmice.id) as broj_utakmica'))
                        ->leftJoin('utakmice', 'takmicenja.id', '=', 'utakmice.takmicenje_id')
                        ->groupBy('takmicenja.id', 'takmicenja.naziv')
                        ->orderBy('broj_utakmica', 'desc')
                        ->get();
                        
        // Ukupan broj golova po timu
        $goloviPoTimu = Tim::select('timovi.id', 'timovi.naziv',
                           DB::raw('SUM(CASE WHEN utakmice.domacin_id = timovi.id THEN utakmice.rezultat_domacin
                                        WHEN utakmice.gost_id = timovi.id THEN utakmice.rezultat_gost
                                        ELSE 0 END) as dati_golovi'),
                           DB::raw('SUM(CASE WHEN utakmice.domacin_id = timovi.id THEN utakmice.rezultat_gost
                                        WHEN utakmice.gost_id = timovi.id THEN utakmice.rezultat_domacin
                                        ELSE 0 END) as primljeni_golovi'))
                  ->leftJoin('utakmice', function($join) {
                      $join->on('timovi.id', '=', 'utakmice.domacin_id')
                           ->orOn('timovi.id', '=', 'utakmice.gost_id');
                  })
                  ->groupBy('timovi.id', 'timovi.naziv')
                  ->orderBy('dati_golovi', 'desc')
                  ->get();
                  
        // Rezultati sa najviše golova
        $utakmiceNajviseGolova = Utakmica::select('utakmice.*', 
                             DB::raw('(utakmice.rezultat_domacin + utakmice.rezultat_gost) as ukupno_golova'),
                             'd.naziv as domacin_naziv',
                             'g.naziv as gost_naziv')
                     ->join('timovi as d', 'utakmice.domacin_id', '=', 'd.id')
                     ->join('timovi as g', 'utakmice.gost_id', '=', 'g.id')
                     ->orderBy('ukupno_golova', 'desc')
                     ->take(10)
                     ->get();
                     
        return view('statistika', compact(
            'takmicenjaBrojUtakmica',
            'goloviPoTimu',
            'utakmiceNajviseGolova'
        ));
    }
    
    /**
     * Prikaz kalendara utakmica.
     */
    public function kalendar(Request $request)
    {
        $godina = $request->query('godina', date('Y'));
        $mesec = $request->query('mesec', date('m'));
        
        $utakmice = Utakmica::with(['domacin', 'gost', 'takmicenje'])
            ->whereYear('datum', $godina)
            ->whereMonth('datum', $mesec)
            ->orderBy('datum')
            ->orderBy('vreme')
            ->get();
            
        return view('kalendar', compact('utakmice', 'godina', 'mesec'));
    }
    
    /**
     * Pretraga.
     */
    public function pretraga(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return view('pretraga', ['rezultati' => null]);
        }
        
        // Pretraga timova
        $timovi = Tim::where('naziv', 'like', "%{$query}%")
                 ->orWhere('zemlja', 'like', "%{$query}%")
                 ->get();
                 
        // Pretraga igrača
        $igraci = Igrac::where('ime', 'like', "%{$query}%")
                 ->orWhere('prezime', 'like', "%{$query}%")
                 ->orWhere(DB::raw("CONCAT(ime, ' ', prezime)"), 'like', "%{$query}%")
                 ->with('tim')
                 ->get();
                 
        // Pretraga utakmica
        $utakmice = Utakmica::select('utakmice.*')
                   ->join('timovi as d', 'utakmice.domacin_id', '=', 'd.id')
                   ->join('timovi as g', 'utakmice.gost_id', '=', 'g.id')
                   ->where('d.naziv', 'like', "%{$query}%")
                   ->orWhere('g.naziv', 'like', "%{$query}%")
                   ->with(['domacin', 'gost', 'takmicenje'])
                   ->get();
                   
        return view('pretraga', [
            'query' => $query,
            'timovi' => $timovi,
            'igraci' => $igraci,
            'utakmice' => $utakmice
        ]);
    }
}