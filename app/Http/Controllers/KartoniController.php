<?php

namespace App\Http\Controllers;

use App\Models\Karton;
use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
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
        
        // Igrači tima koji su u sastavu ove utakmice
        $igraci = Igrac::where('tim_id', $tim_id)->orderBy('prezime')->get();
        
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
            'igrac_id' => 'required|exists:igraci,id',
            'tip' => 'required|in:zuti,crveni',
            'minut' => 'required|integer|min:1|max:120',
        ]);

        Karton::create($validated);

        return redirect()->route('kartoni.index', ['utakmica_id' => $validated['utakmica_id']])
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
        ]);

        $karton->update($validated);

        return redirect()->route('kartoni.index', ['utakmica_id' => $karton->utakmica_id])
            ->with('success', 'Karton uspešno ažuriran.');
    }

    /**
     * Brisanje kartona.
     */
    public function destroy(Karton $karton)
    {
        $utakmica_id = $karton->utakmica_id;
        $karton->delete();
        
        return redirect()->route('kartoni.index', ['utakmica_id' => $utakmica_id])
            ->with('success', 'Karton uspešno obrisan.');
    }
}