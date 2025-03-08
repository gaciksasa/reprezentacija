<?php

namespace App\Http\Controllers;

use App\Models\Igrac;
use App\Models\Tim;
use App\Models\BivsiKlub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IgraciController extends Controller
{
    /**
     * Prikaz svih igrača.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $query = Igrac::query();
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ime', 'like', "%{$search}%")
                  ->orWhere('prezime', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(ime, ' ', prezime) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(prezime, ' ', ime) LIKE ?", ["%{$search}%"]);
            });
        }
        
        // Apply period filter
        if ($request->has('period') && !empty($request->period)) {
            $period = explode('-', $request->period);
            if (count($period) === 2) {
                $startYear = $period[0];
                $endYear = $period[1] === 'danas' ? date('Y') : $period[1];
                
                $query->where(function($q) use ($startYear, $endYear) {
                    $q->whereHas('sastavi', function($sq) use ($startYear, $endYear) {
                        $sq->whereHas('utakmica', function($uq) use ($startYear, $endYear) {
                            $uq->whereYear('datum', '>=', $startYear)
                               ->whereYear('datum', '<=', $endYear);
                        });
                    });
                });
            }
        }
        
        // Apply active filter
        if ($request->has('active') && $request->active == '1') {
            $query->where('aktivan', true);
        }
        
        // Add fields with subqueries for better performance
        $query->addSelect([
            'debitovao_za_tim' => function($q) {
                $q->select('datum')
                  ->from('utakmice')
                  ->join('sastavi', 'utakmice.id', '=', 'sastavi.utakmica_id')
                  ->whereColumn('sastavi.igrac_id', 'igraci.id')
                  ->orderBy('datum', 'asc')
                  ->limit(1);
            },
            'poslednja_utakmica' => function($q) {
                $q->select('datum')
                  ->from('utakmice')
                  ->join('sastavi', 'utakmice.id', '=', 'sastavi.utakmica_id')
                  ->whereColumn('sastavi.igrac_id', 'igraci.id')
                  ->orderBy('datum', 'desc')
                  ->limit(1);
            },
            'broj_nastupa' => function($q) {
                $q->selectRaw('COUNT(*)')
                  ->from('sastavi')
                  ->whereColumn('sastavi.igrac_id', 'igraci.id');
            },
            'broj_golova' => function($q) {
                $q->selectRaw('COUNT(*)')
                  ->from('golovi')
                  ->whereColumn('golovi.igrac_id', 'igraci.id')
                  ->where('auto_gol', false);
            }
        ]);
        
        // Order by player's last name
        $query->orderBy('prezime')->orderBy('ime');
        
        // Get ALL players without pagination
        $igraci = $query->get();
        
        return view('igraci.index', compact('igraci'));
    }

    /**
     * Prikaz forme za kreiranje igrača.
     */
    public function create()
    {
        $pozicije = ['Golman', 'Odbrana', 'Sredina', 'Napad'];
        return view('igraci.create', compact('pozicije'));
    }

    /**
     * Čuvanje novog igrača.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'pozicija' => 'required|in:Golman,Odbrana,Sredina,Napad',
            'datum_rodjenja' => 'nullable|date',
            'mesto_rodjenja' => 'nullable|string|max:255',
            'datum_smrti' => 'nullable|date|after_or_equal:datum_rodjenja',
            'mesto_smrti' => 'nullable|string|max:255',
            'biografija' => 'nullable|string',
            'fotografija' => 'nullable|image|max:2048', // max 2MB
            'aktivan' => 'boolean',
        ]);
        
        // Set the aktivan field to true if checked, false otherwise
        $validated['aktivan'] = $request->has('aktivan');

        // Automatski koristi ID glavnog tima
        $glavniTim = \App\Models\Tim::glavniTim()->first();
        if (!$glavniTim) {
            return redirect()->back()
                ->with('error', 'Glavni tim nije definisan. Molimo prvo definišite glavni tim.');
        }
        $validated['tim_id'] = $glavniTim->id;

        // Handle file upload if there's a photo
        if ($request->hasFile('fotografija')) {
            $path = $request->file('fotografija')->store('igraci', 'public');
            $validated['fotografija_path'] = $path;
        }

        // Create player
        $igrac = Igrac::create($validated);

        // Process bivsi klubovi
        if ($request->has('bivsi_klubovi')) {
            foreach ($request->bivsi_klubovi as $klub) {
                if (!empty($klub['naziv'])) { // Only add if klub name is provided
                    $igrac->bivsiKlubovi()->create([
                        'naziv' => $klub['naziv'],
                        'drzava' => $klub['drzava'] ?? null,
                        'stepen_takmicenja' => $klub['stepen_takmicenja'] ?? null,
                        'broj_nastupa' => $klub['broj_nastupa'] ?? null,
                        'broj_golova' => $klub['broj_golova'] ?? null,
                        'period_od' => $klub['period_od'] ?? null,
                        'period_do' => $klub['period_do'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('igraci.index')
            ->with('success', 'Igrač uspešno kreiran.');
    }

    /**
     * Prikaz pojedinačnog igrača.
     */
    public function show(Igrac $igrac)
    {
        $igrac->load(['golovi.utakmica', 'kartoni.utakmica', 'bivsiKlubovi']);
        return view('igraci.show', compact('igrac'));
    }

    /**
     * Prikaz forme za izmenu igrača.
     */
    public function edit(Igrac $igrac)
    {
        $pozicije = ['Golman', 'Odbrana', 'Sredina', 'Napad'];
        $igrac->load('bivsiKlubovi');
        return view('igraci.edit', compact('igrac', 'pozicije'));
    }

    /**
     * Ažuriranje igrača.
     */
    public function update(Request $request, Igrac $igrac)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'pozicija' => 'required|in:Golman,Odbrana,Sredina,Napad',
            'datum_rodjenja' => 'nullable|date',
            'mesto_rodjenja' => 'nullable|string|max:255',
            'datum_smrti' => 'nullable|date|after_or_equal:datum_rodjenja',
            'mesto_smrti' => 'nullable|string|max:255',
            'biografija' => 'nullable|string',
            'fotografija' => 'nullable|image|max:2048', // max 2MB
            'aktivan' => 'boolean',
        ]);
        
        // Set the aktivan field to true if checked, false otherwise
        $validated['aktivan'] = $request->has('aktivan');

        // Ne menjamo tim_id pri ažuriranju

        // Handle file upload if there's a new photo
        if ($request->hasFile('fotografija')) {
            // Delete old photo if exists
            if ($igrac->fotografija_path) {
                Storage::disk('public')->delete($igrac->fotografija_path);
            }
            
            $path = $request->file('fotografija')->store('igraci', 'public');
            $validated['fotografija_path'] = $path;
        }

        // Debugging to see what's being passed
        \Log::debug('Aktivan vrednost: ' . ($request->has('aktivan') ? 'true' : 'false'));
        \Log::debug('Validated data: ', $validated);

        $igrac->update($validated);

        // Handle bivsi klubovi
        if ($request->has('bivsi_klubovi')) {
            // Get IDs of existing clubs that should be kept
            $existingIds = [];
            
            foreach ($request->bivsi_klubovi as $index => $klubData) {
                if (!empty($klubData['naziv'])) {
                    if (isset($klubData['id'])) {
                        // Update existing club
                        $klub = BivsiKlub::find($klubData['id']);
                        if ($klub && $klub->igrac_id == $igrac->id) {
                            $klub->update([
                                'naziv' => $klubData['naziv'],
                                'drzava' => $klubData['drzava'] ?? null,
                                'stepen_takmicenja' => $klubData['stepen_takmicenja'] ?? null,
                                'broj_nastupa' => $klubData['broj_nastupa'] ?? null,
                                'broj_golova' => $klubData['broj_golova'] ?? null,
                                'period_od' => $klubData['period_od'] ?? null,
                                'period_do' => $klubData['period_do'] ?? null,
                            ]);
                            $existingIds[] = $klub->id;
                        }
                    } else {
                        // Create new club
                        $klub = $igrac->bivsiKlubovi()->create([
                            'naziv' => $klubData['naziv'],
                            'drzava' => $klubData['drzava'] ?? null,
                            'stepen_takmicenja' => $klubData['stepen_takmicenja'] ?? null,
                            'broj_nastupa' => $klubData['broj_nastupa'] ?? null,
                            'broj_golova' => $klubData['broj_golova'] ?? null,
                            'period_od' => $klubData['period_od'] ?? null,
                            'period_do' => $klubData['period_do'] ?? null,
                        ]);
                        $existingIds[] = $klub->id;
                    }
                }
            }
            
            // Delete clubs that are no longer in the form
            $igrac->bivsiKlubovi()->whereNotIn('id', $existingIds)->delete();
        } else {
            // If no clubs provided, delete all existing
            $igrac->bivsiKlubovi()->delete();
        }

        // Redirect back to the edit page instead of index
        return back()->with('success', 'Igrač uspešno ažuriran.');
    }

    /**
     * Brisanje igrača.
     */
    public function destroy(Igrac $igrac)
    {
        try {
            // Delete associated photo if exists
            if ($igrac->fotografija_path) {
                Storage::disk('public')->delete($igrac->fotografija_path);
            }
            
            $igrac->delete();
            return redirect()->route('igraci.index')
                ->with('success', 'Igrač uspešno obrisan.');
        } catch (\Exception $e) {
            return redirect()->route('igraci.index')
                ->with('error', 'Igrača nije moguće obrisati jer se koristi u drugim tabelama.');
        }
    }

    /**
     * Dodaje novi klub igraču.
     */
    public function updateClub(Request $request, Igrac $igrac)
    {
        $validated = $request->validate([
            'klub' => 'required|string|max:255',
            'drzava_kluba' => 'nullable|string|max:255',
            'sezona' => 'required|string|max:10',
            'stepen_takmicenja' => 'nullable|string|max:100',
            'broj_nastupa' => 'nullable|integer|min:0',
            'broj_golova' => 'nullable|integer|min:0',
        ]);

        // Mapiranje polja forme na kolone u bazi
        $igrac->bivsiKlubovi()->create([
            'naziv' => $validated['klub'],
            'drzava' => $validated['drzava_kluba'],
            'sezona' => $validated['sezona'],
            'stepen_takmicenja' => $validated['stepen_takmicenja'],
            'broj_nastupa' => $validated['broj_nastupa'],
            'broj_golova' => $validated['broj_golova'],
        ]);

        return redirect()->route('igraci.show', $igrac)
            ->with('success', 'Klub uspešno dodat.');
    }

    /**
     * Briše klub igrača.
     */
    public function deleteClub(BivsiKlub $klub)
    {
        $igrac_id = $klub->igrac_id;
        $klub->delete();
        
        return redirect()->route('igraci.show', $igrac_id)
            ->with('success', 'Klub uspešno obrisan.');
    }
}