<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimVarijanteController extends Controller
{
    /**
     * Display main team and its aliases.
     */
    public function index()
    {
        $glavniTim = Tim::glavniTim()->first();
        
        if (!$glavniTim) {
            return redirect()->route('timovi.index')
                ->with('error', 'Glavni tim nije definisan.');
        }
        
        $varijante = Tim::where('maticni_tim_id', $glavniTim->id)
            ->orderBy('aktivan_od', 'desc')
            ->get();
            
        return view('tim_varijante.index', compact('glavniTim', 'varijante'));
    }

    /**
     * Show the form for creating a new alias.
     */
    public function create()
    {
        $glavniTim = Tim::glavniTim()->first();
        
        if (!$glavniTim) {
            return redirect()->route('timovi.index')
                ->with('error', 'Glavni tim nije definisan.');
        }
        
        return view('tim_varijante.create', compact('glavniTim'));
    }

    /**
     * Store a newly created alias.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'skraceni_naziv' => 'nullable|string|max:50',
            'zemlja' => 'required|string|max:100',
            'aktivan_od' => 'required|date',
            'aktivan_do' => 'nullable|date|after_or_equal:aktivan_od',
            'zastava_url' => 'nullable|string|max:255',
            'grb_url' => 'nullable|string|max:255',
        ]);

        $glavniTim = Tim::glavniTim()->first();
        
        if (!$glavniTim) {
            return redirect()->route('timovi.index')
                ->with('error', 'Glavni tim nije definisan.');
        }
        
        $validated['maticni_tim_id'] = $glavniTim->id;
        
        Tim::create($validated);

        return redirect()->route('tim-varijante.index')
            ->with('success', 'Nova varijanta tima je uspešno kreirana.');
    }

    /**
     * Show the form for editing an alias.
     */
    public function edit($id)
    {
        $varijanta = Tim::findOrFail($id);
        
        if (!$varijanta->maticni_tim_id) {
            return redirect()->route('tim-varijante.index')
                ->with('error', 'Možete menjati samo varijante tima.');
        }
        
        $glavniTim = Tim::glavniTim()->first();
        
        return view('tim_varijante.edit', compact('varijanta', 'glavniTim'));
    }

    /**
     * Update the specified alias.
     */
    public function update(Request $request, $id)
    {
        $varijanta = Tim::findOrFail($id);
        
        if (!$varijanta->maticni_tim_id) {
            return redirect()->route('tim-varijante.index')
                ->with('error', 'Možete ažurirati samo varijante tima.');
        }
        
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'skraceni_naziv' => 'nullable|string|max:50',
            'zemlja' => 'required|string|max:100',
            'aktivan_od' => 'required|date',
            'aktivan_do' => 'nullable|date|after_or_equal:aktivan_od',
            'zastava_url' => 'nullable|string|max:255',
            'grb_url' => 'nullable|string|max:255',
        ]);

        $varijanta->update($validated);

        return redirect()->route('tim-varijante.index')
            ->with('success', 'Varijanta tima je uspešno ažurirana.');
    }

    /**
     * Remove the specified alias.
     */
    public function destroy($id)
    {
        $varijanta = Tim::findOrFail($id);
        
        if (!$varijanta->maticni_tim_id) {
            return redirect()->route('tim-varijante.index')
                ->with('error', 'Možete obrisati samo varijante tima.');
        }
        
        try {
            $varijanta->delete();
            return redirect()->route('tim-varijante.index')
                ->with('success', 'Varijanta tima je uspešno obrisana.');
        } catch (\Exception $e) {
            return redirect()->route('tim-varijante.index')
                ->with('error', 'Ne može se obrisati varijanta tima jer se koristi u drugim tabelama.');
        }
    }
    
    /**
     * Set a team as the main team.
     */
    public function postaviGlavniTim(Request $request, $id)
    {
        $tim = Tim::findOrFail($id);
        
        // First, unset any existing main team
        Tim::where('glavni_tim', true)->update(['glavni_tim' => false]);
        
        // Set this team as the main team
        $tim->update([
            'glavni_tim' => true,
            'maticni_tim_id' => null // Main team can't be an alias
        ]);
        
        return redirect()->route('timovi.index')
            ->with('success', "Tim {$tim->naziv} je uspešno postavljen kao glavni tim.");
    }
}