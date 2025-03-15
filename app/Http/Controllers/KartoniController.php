<?php

namespace App\Http\Controllers;

use App\Models\Karton;
use App\Models\Igrac;
use App\Models\ProtivnickiIgrac;
use App\Models\Tim;
use App\Models\Utakmica;
use App\Models\Sastav;
use Illuminate\Http\Request;

class KartoniController extends Controller
{
    /**
     * Prikaz kartona za određenu utakmicu.
     */
    public function index(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        
        if ($utakmica_id) {
            $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
            
            $kartoni = Karton::where('utakmica_id', $utakmica_id)
                ->with(['tim', 'igrac'])
                ->orderBy('minut')
                ->get();
                
            return view('kartoni.index', compact('utakmica', 'kartoni'));
        }
        
        $utakmice = Utakmica::with(['domacin', 'gost'])
            ->orderBy('datum', 'desc')
            ->paginate(10);
            
        return view('kartoni.select_utakmica', compact('utakmice'));
    }

    /**
     * Prikaz forme za dodavanje kartona.
     */
    public function create(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        $tim_id = $request->query('tim_id');
        
        if (!$utakmica_id || !$tim_id) {
            return redirect()->route('kartoni.index')
                ->with('error', 'Morate izabrati utakmicu i tim.');
        }
        
        $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
        $tim = Tim::findOrFail($tim_id);
        
        // Provera da li je tim učesnik utakmice
        if ($utakmica->domacin_id != $tim_id && $utakmica->gost_id != $tim_id) {
            return redirect()->route('kartoni.index', ['utakmica_id' => $utakmica_id])
                ->with('error', 'Izabrani tim nije učesnik ove utakmice.');
        }
        
        // Dobavi glavni tim za proveru
        $glavniTim = Tim::glavniTim()->first();
        $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
        $isNasTim = in_array($tim_id, $glavniTimIds);
        
        // Igrači tima koji su u sastavu ove utakmice
        if ($isNasTim) {
            $sastavi = \App\Models\Sastav::where('utakmica_id', $utakmica_id)
                ->where('tim_id', $tim_id)
                ->get();
                
            $igraci = [];
            foreach($sastavi as $sastav) {
                $igrac = Igrac::find($sastav->igrac_id);
                if ($igrac) {
                    $igraci[] = $igrac;
                }
            }
            $igraci = collect($igraci)->sortBy('prezime')->values();
            
            // Ako nema igrača u sastavu, prikaži sve igrače tima
            if (count($igraci) == 0) {
                $igraci = Igrac::whereIn('tim_id', $glavniTimIds)
                    ->orderBy('prezime')
                    ->get();
            }
        } else {
            // Za protivnički tim, dohvati protivničke igrače
            $igraci = ProtivnickiIgrac::where('utakmica_id', $utakmica_id)
                ->where('tim_id', $tim_id)
                ->orderBy('prezime')
                ->get();
        }
        
        return view('kartoni.create', compact('utakmica', 'tim', 'igraci'));
    }

    /**
     * Čuvanje novog kartona.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'utakmica_id' => 'required|exists:utakmice,id',
            'tim_id' => 'required|exists:timovi,id',
            'igrac_id' => 'required',
            'tip' => 'required|in:zuti,crveni',
            'minut' => 'required|integer|min:1|max:120',
        ]);

        // Set drugi_zuti based on checkbox presence
        $validated['drugi_zuti'] = $request->has('drugi_zuti');
        
        // If it's marked as second yellow, automatically set type to red
        if ($validated['drugi_zuti']) {
            $validated['tip'] = 'crveni';
        }

        // Check if this is for our team or opponent team
        $glavniTim = Tim::glavniTim()->first();
        $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
        $isNasTim = in_array($validated['tim_id'], $glavniTimIds);

        // If opponent team, check if it's an opponent player
        if (!$isNasTim) {
            // Check if igrac_id exists in opponent players
            $protivnickiIgrac = ProtivnickiIgrac::find($validated['igrac_id']);
            if ($protivnickiIgrac) {
                // Save card for opponent player
                $karton = new Karton([
                    'utakmica_id' => $validated['utakmica_id'],
                    'tim_id' => $validated['tim_id'],
                    'igrac_id' => $validated['igrac_id'],
                    'tip' => $validated['tip'],
                    'minut' => $validated['minut'],
                    'drugi_zuti' => $validated['drugi_zuti'],
                ]);
                $karton->save();
                return redirect()->route('utakmice.show', $validated['utakmica_id'])
                    ->with('success', 'Karton uspešno zabeležen.');
            }
        }

        // Standard card creation
        Karton::create($validated);

        return redirect()->route('utakmice.show', $validated['utakmica_id'])
            ->with('success', 'Karton uspešno zabeležen.');
    }

    /**
     * Prikaz pojedinačnog kartona.
     */
    public function show(Karton $karton)
    {
        $karton->load(['utakmica', 'tim', 'igrac']);
        return view('kartoni.show', compact('karton'));
    }

    /**
     * Prikaz forme za izmenu kartona.
     */
    public function edit(Karton $karton)
    {
        $karton->load(['utakmica.domacin', 'utakmica.gost', 'tim', 'igrac']);
        
        $igraci = Igrac::where('tim_id', $karton->tim_id)->orderBy('prezime')->get();
        
        return view('kartoni.edit', compact('karton', 'igraci'));
    }

    /**
     * Ažuriranje kartona.
     */
    public function update(Request $request, Karton $karton)
    {
        $validated = $request->validate([
            'igrac_id' => 'required|exists:igraci,id',
            'tip' => 'required|in:zuti,crveni',
            'minut' => 'required|integer|min:1|max:120',
            'drugi_zuti' => 'boolean',
        ]);

        // Ako je označeno kao drugi žuti, automatski postavimo tip na crveni
        if ($request->has('drugi_zuti') && $request->drugi_zuti) {
            $validated['drugi_zuti'] = true;
            $validated['tip'] = 'crveni';
        } else {
            $validated['drugi_zuti'] = false;
        }

        $karton->update($validated);

        return redirect()->route('kartoni.index', ['utakmica_id' => $karton->utakmica_id])
            ->with('success', 'Karton uspešno ažuriran.');
    }

    /**
     * Brisanje kartona.
     */
    public function destroy($id)
    {
        // Find the karton record by ID
        $karton = Karton::findOrFail($id);
        
        // Store match ID before deletion
        $utakmica_id = $karton->utakmica_id;
        
        // Delete the record
        $karton->delete();
        
        // Redirect back to match page
        return redirect()->route('utakmice.show', $utakmica_id)
            ->with('success', 'Karton uspešno obrisan.');
    }
}