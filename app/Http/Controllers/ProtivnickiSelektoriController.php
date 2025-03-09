<?php

namespace App\Http\Controllers;

use App\Models\ProtivnickiSelektor;
use App\Models\Utakmica;
use App\Models\Tim;
use Illuminate\Http\Request;

class ProtivnickiSelektoriController extends Controller
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
        
        // Proveri da li već postoji selektor za ovaj tim i utakmicu
        $postojeciSelektor = ProtivnickiSelektor::where('utakmica_id', $utakmica_id)
            ->where('tim_id', $tim_id)
            ->first();
            
        return view('protivnicki-selektori.create', compact('utakmica', 'tim', 'postojeciSelektor'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'utakmica_id' => 'required|exists:utakmice,id',
            'tim_id' => 'required|exists:timovi,id',
            'ime_prezime' => 'required|string|max:255',
            'napomena' => 'nullable|string',
        ]);

        // Koristi updateOrCreate da izbegneš duple unose
        ProtivnickiSelektor::updateOrCreate(
            ['utakmica_id' => $validated['utakmica_id'], 'tim_id' => $validated['tim_id']],
            [
                'ime_prezime' => $validated['ime_prezime'],
                'napomena' => $validated['napomena'] ?? null
            ]
        );

        return redirect()->route('utakmice.show', $validated['utakmica_id'])
            ->with('success', 'Selektor protivničkog tima uspešno dodat.');
    }

    public function edit($id)
    {
        $selektor = ProtivnickiSelektor::with(['utakmica', 'tim'])->findOrFail($id);
        return view('protivnicki-selektori.edit', compact('selektor'));
    }

    public function update(Request $request, $id)
    {
        $selektor = ProtivnickiSelektor::findOrFail($id);
        
        $validated = $request->validate([
            'ime_prezime' => 'required|string|max:255',
            'napomena' => 'nullable|string',
        ]);

        $selektor->update($validated);

        return redirect()->route('utakmice.show', $selektor->utakmica_id)
            ->with('success', 'Selektor protivničkog tima uspešno ažuriran.');
    }

    public function destroy($id)
    {
        $selektor = ProtivnickiSelektor::findOrFail($id);
        $utakmica_id = $selektor->utakmica_id;
        $selektor->delete();
        
        return redirect()->route('utakmice.show', $utakmica_id)
            ->with('success', 'Selektor protivničkog tima uspešno obrisan.');
    }
}