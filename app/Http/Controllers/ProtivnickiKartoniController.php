<?php

namespace App\Http\Controllers;

use App\Models\ProtivnickiKarton;
use App\Models\ProtivnickiIgrac;
use App\Models\Utakmica;
use App\Models\Tim;
use Illuminate\Http\Request;

class ProtivnickiKartoniController extends Controller
{
    public function create(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        $tim_id = $request->query('tim_id');
        
        if (!$utakmica_id || !$tim_id) {
            return redirect()->route('utakmice.index')
                ->with('error', 'Morate izabrati utakmicu i tim.');
        }
        
        $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
        $tim = Tim::findOrFail($tim_id);
        
        // Provera da li je tim učesnik utakmice
        if ($utakmica->domacin_id != $tim_id && $utakmica->gost_id != $tim_id) {
            return redirect()->route('utakmice.show', $utakmica)
                ->with('error', 'Izabrani tim nije učesnik ove utakmice.');
        }
        
        // Dohvati protivničke igrače
        $igraci = ProtivnickiIgrac::where('utakmica_id', $utakmica_id)
            ->where('tim_id', $tim_id)
            ->orderBy('prezime')
            ->get();
            
        if ($igraci->isEmpty()) {
            return redirect()->route('protivnicki-igraci.index', ['utakmica_id' => $utakmica_id, 'tim_id' => $tim_id])
                ->with('error', 'Nema evidentiranih igrača za ovaj tim na ovoj utakmici. Prvo dodajte igrače.');
        }
        
        return view('protivnicki-kartoni.create', compact('utakmica', 'tim', 'igraci'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'utakmica_id' => 'required|exists:utakmice,id',
            'tim_id' => 'required|exists:timovi,id',
            'igrac_id' => 'required|exists:protivnicki_igraci,id',
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

        ProtivnickiKarton::create($validated);

        return redirect()->route('utakmice.show', $validated['utakmica_id'])
            ->with('success', 'Karton uspešno zabeležen.');
    }

    public function destroy($id)
    {
        $karton = ProtivnickiKarton::findOrFail($id);
        $utakmica_id = $karton->utakmica_id;
        $karton->delete();
        
        return redirect()->route('utakmice.show', $utakmica_id)
            ->with('success', 'Karton uspešno obrisan.');
    }
}