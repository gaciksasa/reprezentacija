<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
use App\Models\Takmicenje;
use App\Models\Kategorija;
use App\Models\Gol;
use App\Models\Karton;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Prikaz početne stranice sa statistikom.
     */
    public function index()
    {
        // Get Serbia as the main team
        $glavniTim = Tim::glavniTim()->first();
        
        if (!$glavniTim) {
            // Fallback if no main team set
            $glavniTim = Tim::where('naziv', 'Srbija')->first();
        }
        
        // Include all aliases of the main team
        $timIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];

        // Trenutno vreme
        $sada = Carbon::now();

        // Poslednja odigrana utakmica
        // Utakmica se smatra odigranom 3 sata nakon planiranog početka
        $poslednjaMec = Utakmica::with(['domacin', 'gost', 'takmicenje'])
            ->where(function($query) use ($timIds) {
                $query->whereIn('domacin_id', $timIds)
                      ->orWhereIn('gost_id', $timIds);
            })
            ->where(function($query) use ($sada) {
                // Utakmica je odigrana ako je:
                // 1. Datum je u prošlosti, ili
                // 2. Datum je danas ali je prošlo 3 sata od planiranog početka
                $query->whereDate('datum', '<', $sada->toDateString())
                      ->orWhere(function($q) use ($sada) {
                          $q->whereDate('datum', '=', $sada->toDateString())
                            ->where(function($timeQuery) use ($sada) {
                                // Ako postoji vreme, proveri da li je prošlo 3 sata od početka
                                $timeQuery->whereNotNull('vreme')
                                         ->whereRaw("DATE_ADD(CONCAT(datum, ' ', vreme), INTERVAL 3 HOUR) <= ?", [
                                             $sada->format('Y-m-d H:i:s')
                                         ]);
                            })
                            ->orWhere(function($noTimeQuery) use ($sada) {
                                // Ako nema vreme, pretpostavi 19:00 + 3 sata = 22:00
                                $noTimeQuery->whereNull('vreme')
                                           ->whereRaw("DATE_ADD(CONCAT(datum, ' 19:00:00'), INTERVAL 3 HOUR) <= ?", [
                                               $sada->format('Y-m-d H:i:s')
                                           ]);
                            });
                      });
            })
            ->orderBy('datum', 'desc')
            ->orderBy('vreme', 'desc')
            ->first();

        // Sledeća utakmica
        // Utakmica se smatra predstojećom dok ne prođe 3 sata od planiranog početka
        $sledeciMec = Utakmica::with(['domacin', 'gost', 'takmicenje'])
            ->where(function($query) use ($timIds) {
                $query->whereIn('domacin_id', $timIds)
                      ->orWhereIn('gost_id', $timIds);
            })
            ->where(function($query) use ($sada) {
                // Utakmica je predstojeća ako je:
                // 1. Datum je u budućnosti, ili
                // 2. Datum je danas ali nije prošlo 3 sata od planiranog početka
                $query->whereDate('datum', '>', $sada->toDateString())
                      ->orWhere(function($q) use ($sada) {
                          $q->whereDate('datum', '=', $sada->toDateString())
                            ->where(function($timeQuery) use ($sada) {
                                // Ako postoji vreme, proveri da li nije prošlo 3 sata
                                $timeQuery->whereNotNull('vreme')
                                         ->whereRaw("DATE_ADD(CONCAT(datum, ' ', vreme), INTERVAL 3 HOUR) > ?", [
                                             $sada->format('Y-m-d H:i:s')
                                         ]);
                            })
                            ->orWhere(function($noTimeQuery) use ($sada) {
                                // Ako nema vreme, pretpostavi 19:00 + 3 sata = 22:00
                                $noTimeQuery->whereNull('vreme')
                                           ->whereRaw("DATE_ADD(CONCAT(datum, ' 19:00:00'), INTERVAL 3 HOUR) > ?", [
                                               $sada->format('Y-m-d H:i:s')
                                           ]);
                            });
                      });
            })
            ->orderBy('datum', 'asc')
            ->orderBy('vreme', 'asc')
            ->first();

        // Utakmica nakon sledeće (koristi istu logiku kao sledeća utakmica)
        if ($sledeciMec) {
            $nakonSledecegMec = Utakmica::with(['domacin', 'gost', 'takmicenje'])
                ->where(function($query) use ($timIds) {
                    $query->whereIn('domacin_id', $timIds)
                          ->orWhereIn('gost_id', $timIds);
                })
                ->where(function($query) use ($sada) {
                    // Ista logika kao za sledeći meč
                    $query->whereDate('datum', '>', $sada->toDateString())
                          ->orWhere(function($q) use ($sada) {
                              $q->whereDate('datum', '=', $sada->toDateString())
                                ->where(function($timeQuery) use ($sada) {
                                    $timeQuery->whereNotNull('vreme')
                                             ->whereRaw("DATE_ADD(CONCAT(datum, ' ', vreme), INTERVAL 3 HOUR) > ?", [
                                                 $sada->format('Y-m-d H:i:s')
                                             ]);
                                })
                                ->orWhere(function($noTimeQuery) use ($sada) {
                                    $noTimeQuery->whereNull('vreme')
                                               ->whereRaw("DATE_ADD(CONCAT(datum, ' 19:00:00'), INTERVAL 3 HOUR) > ?", [
                                                   $sada->format('Y-m-d H:i:s')
                                               ]);
                                });
                          });
                })
                ->where(function($query) use ($sledeciMec) {
                    // Mora biti nakon sledeće utakmice
                    $query->where('datum', '>', $sledeciMec->datum)
                          ->orWhere(function($q) use ($sledeciMec) {
                              $q->where('datum', '=', $sledeciMec->datum)
                                ->where('vreme', '>', $sledeciMec->vreme ?? '00:00');
                          });
                })
                ->orderBy('datum', 'asc')
                ->orderBy('vreme', 'asc')
                ->first();
        } else {
            $nakonSledecegMec = null;
        }
        
        // Poslednje odigrane utakmice glavnog tima (koristi novu logiku)
        $poslednjeUtakmice = Utakmica::with(['domacin', 'gost', 'takmicenje'])
            ->where(function($query) use ($timIds) {
                $query->whereIn('domacin_id', $timIds)
                      ->orWhereIn('gost_id', $timIds);
            })
            ->where(function($query) use ($sada) {
                // Ista logika kao za poslednju utakmicu
                $query->whereDate('datum', '<', $sada->toDateString())
                      ->orWhere(function($q) use ($sada) {
                          $q->whereDate('datum', '=', $sada->toDateString())
                            ->where(function($timeQuery) use ($sada) {
                                $timeQuery->whereNotNull('vreme')
                                         ->whereRaw("DATE_ADD(CONCAT(datum, ' ', vreme), INTERVAL 3 HOUR) <= ?", [
                                             $sada->format('Y-m-d H:i:s')
                                         ]);
                            })
                            ->orWhere(function($noTimeQuery) use ($sada) {
                                $noTimeQuery->whereNull('vreme')
                                           ->whereRaw("DATE_ADD(CONCAT(datum, ' 19:00:00'), INTERVAL 3 HOUR) <= ?", [
                                               $sada->format('Y-m-d H:i:s')
                                           ]);
                            });
                      });
            })
            ->orderBy('datum', 'desc')
            ->orderBy('vreme', 'desc')
            ->take(5)
            ->get();
            
        // Ukupan broj timova, igrača i utakmica
        $brojTimova = Tim::count();
        $brojIgraca = Igrac::count();
        $brojUtakmica = Utakmica::count();
        
        // Broj utakmica glavnog tima
        $brojUtakmicaGlavnogTima = Utakmica::where(function($query) use ($timIds) {
                $query->whereIn('domacin_id', $timIds)
                    ->orWhereIn('gost_id', $timIds);
            })->count();
        
        // Pobede, remiji i porazi glavnog tima
        $pobede = 0;
        $neresene = 0;
        $porazi = 0;
        
        $sveUtakmice = Utakmica::whereIn('domacin_id', $timIds)
            ->orWhereIn('gost_id', $timIds)
            ->get();
            
        foreach ($sveUtakmice as $utakmica) {
            if (in_array($utakmica->domacin_id, $timIds)) {
                // Main team is home
                if ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                    $pobede++;
                } elseif ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                    $porazi++;
                } else {
                    $neresene++;
                }
            } else {
                // Main team is away
                if ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                    $pobede++;
                } elseif ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                    $porazi++;
                } else {
                    $neresene++;
                }
            }
        }
        
        // Najbolji strelci glavnog tima - AŽURIRANO DA UKLJUČI SLUG
        $strelci = Igrac::select(
                'igraci.id', 
                'igraci.ime', 
                'igraci.prezime', 
                'igraci.slug',  // DODAJ SLUG KOLONU
                'timovi.naziv as tim',
                DB::raw('COUNT(golovi.id) as broj_golova')
            )
            ->join('golovi', 'igraci.id', '=', 'golovi.igrac_id')
            ->join('timovi', 'igraci.tim_id', '=', 'timovi.id')
            ->join('utakmice', 'golovi.utakmica_id', '=', 'utakmice.id')
            ->where('golovi.auto_gol', false)
            ->where(function($query) {
                $query->where('golovi.igrac_tip', 'regularni')
                ->orWhereNull('golovi.igrac_tip'); // For backward compatibility with older records
            })
            ->where(function($query) use ($timIds) {
                $query->whereIn('igraci.tim_id', $timIds);
            })
            ->whereNotNull('igraci.slug')  // OSIGURAJ DA IGRAČ IMA SLUG
            ->groupBy('igraci.id', 'igraci.ime', 'igraci.prezime', 'igraci.slug', 'timovi.naziv')
            ->orderBy('broj_golova', 'desc')
            ->take(10)
            ->get();

        // Igrači sa najviše nastupa - AŽURIRANO DA UKLJUČI SLUG
        $najviseNastupa = Igrac::select(
                'igraci.id', 
                'igraci.ime', 
                'igraci.prezime', 
                'igraci.slug',  // DODAJ SLUG KOLONU
                'timovi.naziv as tim',
                DB::raw('COUNT(sastavi.id) as broj_nastupa')
            )
            ->join('sastavi', 'igraci.id', '=', 'sastavi.igrac_id')
            ->leftJoin('timovi', 'igraci.tim_id', '=', 'timovi.id')
            ->whereNotNull('igraci.slug')  // OSIGURAJ DA IGRAČ IMA SLUG
            ->groupBy('igraci.id', 'igraci.ime', 'igraci.prezime', 'igraci.slug', 'timovi.naziv')
            ->orderBy('broj_nastupa', 'desc')
            ->take(10)
            ->get();
        
        // Fetch the latest posts for the carousel
        $poslednjiPostovi = Post::published()
            ->orderBy('post_date', 'desc')
            ->take(3)
            ->get();
            
        // Get all active categories with their posts
        $kategorije = Kategorija::has('posts')
            ->orderBy('name')
            ->get();
            
        // For each category, fetch the latest posts
        foreach ($kategorije as $kategorija) {
            $kategorija->latest_posts = $kategorija->posts()
                ->published()
                ->orderBy('post_date', 'desc')
                ->take(3)
                ->get();
        }

        return view('dashboard', compact(
            'glavniTim',
            'poslednjeUtakmice', 
            'brojTimova', 
            'brojIgraca', 
            'brojUtakmica',
            'brojUtakmicaGlavnogTima',
            'pobede',
            'neresene',
            'porazi',
            'strelci',
            'najviseNastupa',
            'poslednjiPostovi',
            'poslednjaMec',
            'sledeciMec',
            'nakonSledecegMec',
            'kategorije'
        ));
    }
    
    /**
     * Prikaz statistike utakmica.
     */
    public function statistika()
    {
        // Get Serbia as the main team
        $glavniTim = Tim::glavniTim()->first();
        
        // Include all aliases of the main team
        $timIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
        
        // Takmičenja sa brojem utakmica glavnog tima
        $takmicenjaBrojUtakmica = Takmicenje::select('takmicenja.id', 'takmicenja.naziv',
                              DB::raw('COUNT(utakmice.id) as broj_utakmica'))
                    ->leftJoin('utakmice', 'takmicenja.id', '=', 'utakmice.takmicenje_id')
                    ->where(function($query) use ($timIds) {
                        $query->whereIn('utakmice.domacin_id', $timIds)
                              ->orWhereIn('utakmice.gost_id', $timIds);
                    })
                    ->groupBy('takmicenja.id', 'takmicenja.naziv')
                    ->orderBy('broj_utakmica', 'desc')
                    ->get();
                    
        // Ukupan broj golova glavnog tima
        $goloviPoTimu = DB::table('utakmice')
            ->selectRaw('
                SUM(CASE 
                    WHEN domacin_id IN (' . implode(',', $timIds ?: [0]) . ') THEN rezultat_domacin 
                    WHEN gost_id IN (' . implode(',', $timIds ?: [0]) . ') THEN rezultat_gost 
                    ELSE 0 
                END) as dati_golovi,
                SUM(CASE 
                    WHEN domacin_id IN (' . implode(',', $timIds ?: [0]) . ') THEN rezultat_gost 
                    WHEN gost_id IN (' . implode(',', $timIds ?: [0]) . ') THEN rezultat_domacin 
                    ELSE 0 
                END) as primljeni_golovi
            ')
            ->where(function($query) use ($timIds) {
                $query->whereIn('domacin_id', $timIds ?: [0])
                    ->orWhereIn('gost_id', $timIds ?: [0]);
            })
            ->first();
                  
        // Rezultati sa najviše golova za glavni tim
        $utakmiceNajviseGolova = Utakmica::select('utakmice.*', 
                         DB::raw('(utakmice.rezultat_domacin + utakmice.rezultat_gost) as ukupno_golova'),
                         'd.naziv as domacin_naziv',
                         'g.naziv as gost_naziv')
                 ->join('timovi as d', 'utakmice.domacin_id', '=', 'd.id')
                 ->join('timovi as g', 'utakmice.gost_id', '=', 'g.id')
                 ->where(function($query) use ($timIds) {
                     $query->whereIn('utakmice.domacin_id', $timIds)
                           ->orWhereIn('utakmice.gost_id', $timIds);
                 })
                 ->orderBy('ukupno_golova', 'desc')
                 ->take(10)
                 ->get();
                 
        return view('statistika', compact(
            'glavniTim',
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
        
        // Get Serbia as the main team
        $glavniTim = Tim::glavniTim()->first();
        
        // Include all aliases of the main team
        $timIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
        
        $utakmice = Utakmica::with(['domacin', 'gost', 'takmicenje'])
            ->where(function($query) use ($timIds) {
                $query->whereIn('domacin_id', $timIds)
                      ->orWhereIn('gost_id', $timIds);
            })
            ->whereYear('datum', $godina)
            ->whereMonth('datum', $mesec)
            ->orderBy('datum')
            ->orderBy('vreme')
            ->get();
            
        return view('kalendar', compact('utakmice', 'godina', 'mesec', 'glavniTim'));
    }
    
    /**
     * Pretraga - AŽURIRANO DA KORISTI SLUG ZA IGRAČE
     */
    public function pretraga(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return view('pretraga', ['rezultati' => null]);
        }
        
        // Get main team for context
        $glavniTim = Tim::glavniTim()->first();
        
        // Pretraga timova
        $timovi = Tim::where('naziv', 'like', "%{$query}%")
                 ->orWhere('zemlja', 'like', "%{$query}%")
                 ->get();
                 
        // Pretraga igrača - AŽURIRANO DA UKLJUČI SLUG
        $igraci = Igrac::select('id', 'ime', 'prezime', 'slug', 'tim_id')
                 ->where('ime', 'like', "%{$query}%")
                 ->orWhere('prezime', 'like', "%{$query}%")
                 ->orWhere(DB::raw("CONCAT(ime, ' ', prezime)"), 'like', "%{$query}%")
                 ->whereNotNull('slug')  // OSIGURAJ DA IGRAČ IMA SLUG
                 ->with('tim')
                 ->get();
                 
        // Pretraga utakmica - include matches with the main team or its variants
        $timIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
        
        $utakmice = Utakmica::select('utakmice.*')
                   ->join('timovi as d', 'utakmice.domacin_id', '=', 'd.id')
                   ->join('timovi as g', 'utakmice.gost_id', '=', 'g.id')
                   ->where(function($q) use ($query) {
                       $q->where('d.naziv', 'like', "%{$query}%")
                         ->orWhere('g.naziv', 'like', "%{$query}%");
                   })
                   ->orWhere(function($q) use ($timIds, $query) {
                       if (!empty($timIds)) {
                           $q->whereIn('utakmice.domacin_id', $timIds)
                             ->orWhereIn('utakmice.gost_id', $timIds);
                       }
                   })
                   ->with(['domacin', 'gost', 'takmicenje'])
                   ->get();
                   
        return view('pretraga', [
            'query' => $query,
            'timovi' => $timovi,
            'igraci' => $igraci,
            'utakmice' => $utakmice,
            'glavniTim' => $glavniTim
        ]);
    }
}