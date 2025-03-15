<?php

namespace App\Http\Controllers;

use App\Models\ProtivnickaIzmena;
use App\Models\ProtivnickiIgrac;
use App\Models\Utakmica;
use App\Models\Tim;
use Illuminate\Http\Request;

class ProtivnickeIzmeneController extends Controller
{
    /**
     * Prikaz forme za izmenu protivničke izmene.
     */
    public function edit($id)
    {
        $izmena = ProtivnickaIzmena::with(['utakmica.domacin', 'utakmica.gost', 'tim', 'igracOut', 'igracIn'])->findOrFail($id);
        
        // Dohvatanje svih protivničkih igrača za ovaj tim na utakmici
        $igraci = ProtivnickiIgrac::where('utakmica_id', $izmena->utakmica_id)
                ->where('tim_id', $izmena->tim_id)
                ->orderBy('prezime')
                ->orderBy('ime')
                ->get();
        
        return view('protivnicke-izmene.edit', compact('izmena', 'igraci'));
    }

    /**
     * Ažuriranje protivničke izmene.
     */
    public function update(Request $request, $id)
    {
        $izmena = ProtivnickaIzmena::findOrFail($id);
        
        $validated = $request->validate([
            'igrac_out_id' => 'required|exists:protivnicki_igraci,id',
            'igrac_in_id' => 'required|exists:protivnicki_igraci,id|different:igrac_out_id',
            'minut' => 'required|integer|min:1|max:120',
            'napomena' => 'nullable|string',
        ]);
        
        $izmena->update($validated);

        return redirect()->route('utakmice.show', $izmena->utakmica_id)
            ->with('success', 'Protivnička izmena uspešno ažurirana.');
    }

    /**
     * Brisanje protivničke izmene.
     */
    public function destroy($id)
    {
        $izmena = ProtivnickaIzmena::findOrFail($id);
        $utakmica_id = $izmena->utakmica_id;
        $izmena->delete();
        
        return redirect()->route('utakmice.show', $utakmica_id)
            ->with('success', 'Protivnička izmena uspešno obrisana.');
    }
}