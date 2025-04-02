<?php

namespace App\Http\Controllers;

use App\Models\ProtivnickiIgrac;
use App\Models\Utakmica;
use App\Models\Tim;
use Illuminate\Http\Request;

class ProtivnickiIgraciController extends Controller
{
    /**
     * Prikaz protivničkih igrača za određenu utakmicu i tim.
     */
    public function index(Request $request)
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
        
        // Provera da li je tim protivnik našeg tima
        $nasTimId = Tim::glavniTim()->first()->id ?? null;
        if ($tim_id == $nasTimId || in_array($tim_id, Tim::glavniTim()->first()->getSviIdTimova() ?? [])) {
            return redirect()->route('utakmice.show', $utakmica)
                ->with('error', 'Ovo je opcija samo za protivnički tim.');
        }
        
        $protivnickiIgraci = ProtivnickiIgrac::where('utakmica_id', $utakmica_id)
            ->where('tim_id', $tim_id)
            ->orderBy('kapiten', 'desc')
            ->orderBy('prezime')
            ->get();
            
        return view('protivnicki-igraci.index', compact('utakmica', 'tim', 'protivnickiIgraci'));
    }

    /**
     * Prikaz forme za dodavanje protivničkog igrača.
     */
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
        
        // Provera da li je tim protivnik našeg tima
        $nasTimId = Tim::glavniTim()->first()->id ?? null;
        if ($tim_id == $nasTimId || in_array($tim_id, Tim::glavniTim()->first()->getSviIdTimova() ?? [])) {
            return redirect()->route('utakmice.show', $utakmica)
                ->with('error', 'Ovo je opcija samo za protivnički tim.');
        }
        
        return view('protivnicki-igraci.create', compact('utakmica', 'tim'));
    }

    /**
     * Čuvanje novog protivničkog igrača.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ime_prezime' => 'required|string|max:255',
            'utakmica_id' => 'required|exists:utakmice,id',
            'tim_id' => 'required|exists:timovi,id',
            'kapiten' => 'boolean',
        ]);
        
        // Get the next order value (max + 1)
        $maxOrder = ProtivnickiIgrac::where('utakmica_id', $validated['utakmica_id'])
            ->where('tim_id', $validated['tim_id'])
            ->max('redosled') ?? 0;
        
        // Razdvajanje imena i prezimena (prvo ime, sve ostalo prezime)
        $imePrezime = explode(' ', $validated['ime_prezime'], 2);
        $ime = $imePrezime[0];
        $prezime = isset($imePrezime[1]) ? $imePrezime[1] : '';
        
        // Postavljamo podrazumevanu vrednost za kapiten
        $kapiten = $request->has('kapiten');
        
        // Kreiramo protivničkog igrača
        $protivnickiIgrac = ProtivnickiIgrac::create([
            'ime' => $ime,
            'prezime' => $prezime,
            'utakmica_id' => $validated['utakmica_id'],
            'tim_id' => $validated['tim_id'],
            'kapiten' => $kapiten,
            'redosled' => $maxOrder + 1,
            'u_sastavu' => true, // Dodaj da je u sastavu
        ]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'igrac' => $protivnickiIgrac
            ]);
        }

        // Redirect to the sastavi page with the utakmica_id parameter
        return redirect()->route('sastavi.index', ['utakmica_id' => $validated['utakmica_id']])
            ->with('success', 'Protivnički igrač uspešno dodat.');
    }

    /**
     * Ažuriranje protivničkog igrača.
     */
    public function update(Request $request, ProtivnickiIgrac $protivnickiIgrac)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'kapiten' => 'boolean',
        ]);
        
        // Postavljamo podrazumevanu vrednost za kapiten
        $validated['kapiten'] = $request->has('kapiten');
        
        $protivnickiIgrac->update($validated);
        
        return redirect()->route('protivnicki-igraci.index', [
                'utakmica_id' => $protivnickiIgrac->utakmica_id, 
                'tim_id' => $protivnickiIgrac->tim_id
            ])
            ->with('success', 'Protivnički igrač uspešno ažuriran.');
    }


    /**
     * Brisanje protivničkog igrača.
     */
    public function destroy($id)
    {
        // Find the opponent player record by ID
        $protivnickiIgrac = ProtivnickiIgrac::findOrFail($id);
        
        // Store match ID before deletion
        $utakmica_id = $protivnickiIgrac->utakmica_id;
        
        // Delete the record
        $protivnickiIgrac->delete();
        
        // Redirect back to match page
        return redirect()->route('utakmice.show', $utakmica_id)
            ->with('success', 'Protivnički igrač uspešno obrisan.');
    }

    /**
     * Ažurira redosled protivničkih igrača.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'protivnicki_igraci' => 'required|array',
                'protivnicki_igraci.*.id' => 'required|integer',
                'protivnicki_igraci.*.redosled' => 'required|integer',
                'utakmica_id' => 'required|integer|exists:utakmice,id',
                'tim_tip' => 'required|string'
            ]);

            $utakmica_id = $validated['utakmica_id'];
            $updatedCount = 0;

            foreach ($request->protivnicki_igraci as $igrac) {
                $igracModel = ProtivnickiIgrac::find($igrac['id']);
                
                if ($igracModel) {
                    $igracModel->redosled = $igrac['redosled'];
                    if ($igracModel->save()) {
                        $updatedCount++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Redosled protivničkih igrača uspešno ažuriran',
                'updated' => $updatedCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Greška pri ažuriranju redosleda protivničkih igrača: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}