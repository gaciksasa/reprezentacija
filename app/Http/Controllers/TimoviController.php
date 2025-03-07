<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use App\Models\Utakmica;
use Illuminate\Http\Request;

class TimoviController extends Controller
{
    /**
     * Prikaz svih timova.
     */
    // app/Http/Controllers/TimoviController.php

    public function index()
    {
        // Get main team and its aliases
        $glavniTim = Tim::glavniTim()->first();
        
        // If there's a main team, collect all its IDs and its aliases' IDs
        $nasTimIds = [];
        if ($glavniTim) {
            $nasTimIds = $glavniTim->getSviIdTimova();
        }
        
        // Get all teams EXCEPT the main team and its aliases
        $timovi = Tim::whereNotIn('id', $nasTimIds ? $nasTimIds : [0])
                    ->orderBy('naziv')
                    ->get();
        
        // Calculate statistics for each team
        foreach ($timovi as $tim) {
            $stats = [
                'ut' => 0,    // Total matches
                'w' => 0,     // Wins
                'd' => 0,     // Draws
                'l' => 0,     // Losses
                'g' => 0,     // Goals scored by our team
                'a' => 0,     // Goals conceded
            ];
            
            // Home matches (where our team was home, current team was away)
            $homeMatches = Utakmica::whereIn('domacin_id', $nasTimIds)
                        ->where('gost_id', $tim->id)
                        ->get();
                        
            // Away matches (where our team was away, current team was home)
            $awayMatches = Utakmica::where('domacin_id', $tim->id)
                        ->whereIn('gost_id', $nasTimIds)
                        ->get();
            
            // Process home matches
            foreach ($homeMatches as $match) {
                $stats['ut']++;
                $stats['g'] += $match->rezultat_domacin;
                $stats['a'] += $match->rezultat_gost;
                
                if ($match->rezultat_domacin > $match->rezultat_gost) {
                    $stats['w']++;
                } elseif ($match->rezultat_domacin < $match->rezultat_gost) {
                    $stats['l']++;
                } else {
                    $stats['d']++;
                }
            }
            
            // Process away matches
            foreach ($awayMatches as $match) {
                $stats['ut']++;
                $stats['g'] += $match->rezultat_gost;
                $stats['a'] += $match->rezultat_domacin;
                
                if ($match->rezultat_domacin < $match->rezultat_gost) {
                    $stats['w']++;
                } elseif ($match->rezultat_domacin > $match->rezultat_gost) {
                    $stats['l']++;
                } else {
                    $stats['d']++;
                }
            }
            
            // Calculate goal difference
            $stats['diff'] = $stats['g'] - $stats['a'];
            
            // Calculate goals per match
            $stats['g_per_match'] = $stats['ut'] > 0 ? round($stats['g'] / $stats['ut'], 2) : 0;
            $stats['a_per_match'] = $stats['ut'] > 0 ? round($stats['a'] / $stats['ut'], 2) : 0;
            
            // Add statistics to the team object
            $tim->stats = $stats;
        }
        
        return view('timovi.index', compact('timovi'));
    }

    /**
     * Prikaz forme za kreiranje tima.
     */
    public function create()
    {
        return view('timovi.create');
    }

    /**
     * Čuvanje novog tima.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'skraceni_naziv' => 'nullable|string|max:50',
            'zemlja' => 'required|string|max:100',
            'zastava_url' => 'nullable|string|max:255',
            'grb_url' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('grb')) {
            $file = $request->file('grb');
            $filename = strtolower($validated['skraceni_naziv']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/grbovi'), $filename);
            $validated['grb_url'] = $filename;
        }

        Tim::create($validated);

        return redirect()->route('timovi.index')
            ->with('success', 'Tim uspešno kreiran.');
    }

    /**
     * Prikaz pojedinog tima.
     */
    public function show($id)
    {
        try {
            // Eksplicitno dohvatamo tim po ID-u umesto da se oslanjamo na route model binding
            $tim = Tim::with(['igraci', 'domaceUtakmice.takmicenje', 'domaceUtakmice.domacin', 
                            'domaceUtakmice.gost', 'gostujuceUtakmice.takmicenje', 
                            'gostujuceUtakmice.domacin', 'gostujuceUtakmice.gost'])
                    ->findOrFail($id);

            return view('timovi.show', compact('tim'));
        } catch (\Exception $e) {
            // U slučaju greške, preusmeravamo korisnika i prikazujemo poruku
            return redirect()->route('timovi.index')
                ->with('error', 'Tim sa ID ' . $id . ' nije pronađen: ' . $e->getMessage());
        }
    }

    /**
     * Prikaz forme za izmenu tima.
     */
    public function edit(Tim $tim)
    {
        return view('timovi.edit', compact('tim'));
    }

    /**
     * Ažuriranje tima.
     */
    public function update(Request $request, Tim $tim)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'skraceni_naziv' => 'nullable|string|max:50',
            'zemlja' => 'required|string|max:100',
            'zastava_url' => 'nullable|string|max:255',
            'grb_url' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('grb')) {
            $file = $request->file('grb');
            $filename = strtolower($validated['skraceni_naziv']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/grbovi'), $filename);
            $validated['grb_url'] = $filename;
        }

        $tim->update($validated);

        return redirect()->route('timovi.index')
            ->with('success', 'Tim uspešno ažuriran.');
    }

    /**
     * Brisanje tima.
     */
    public function destroy(Tim $tim)
    {
        try {
            $tim->delete();
            return redirect()->route('timovi.index')
                ->with('success', 'Tim uspešno obrisan.');
        } catch (\Exception $e) {
            return redirect()->route('timovi.index')
                ->with('error', 'Tim nije moguće obrisati jer se koristi u drugim tabelama.');
        }
    }
}