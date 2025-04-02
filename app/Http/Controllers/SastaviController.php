<?php

namespace App\Http\Controllers;

use App\Models\Sastav;
use App\Models\Utakmica;
use App\Models\Tim;
use App\Models\Igrac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProtivnickiIgraciController;

class SastaviController extends Controller
{
    /**
     * Prikaz sastava za određenu utakmicu.
     */
    public function index(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        
        if ($utakmica_id) {
            $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
            
            $domaciSastav = Sastav::where('utakmica_id', $utakmica_id)
                ->where('tim_id', $utakmica->domacin_id)
                ->with('igrac')
                ->orderBy('starter', 'desc')
                ->get();
                
            $gostujuciSastav = Sastav::where('utakmica_id', $utakmica_id)
                ->where('tim_id', $utakmica->gost_id)
                ->with('igrac')
                ->orderBy('starter', 'desc')
                ->get();
                
            return view('sastavi.index', compact('utakmica', 'domaciSastav', 'gostujuciSastav'));
        }
        
        $utakmice = Utakmica::with(['domacin', 'gost'])
            ->orderBy('datum', 'desc')
            ->paginate(10);
            
        return view('sastavi.select_utakmica', compact('utakmice'));
    }

    /**
     * Prikaz forme za kreiranje sastava utakmice.
     */
    public function create(Request $request)
    {
        $utakmica_id = $request->query('utakmica_id');
        $tim_id = $request->query('tim_id');
        
        if (!$utakmica_id || !$tim_id) {
            return redirect()->route('sastavi.index')
                ->with('error', 'Morate izabrati utakmicu i tim.');
        }
        
        $utakmica = Utakmica::with(['domacin', 'gost'])->findOrFail($utakmica_id);
        $tim = Tim::findOrFail($tim_id);
        
        // Provera da li je tim učesnik utakmice
        if ($utakmica->domacin_id != $tim_id && $utakmica->gost_id != $tim_id) {
            return redirect()->route('sastavi.index', ['utakmica_id' => $utakmica_id])
                ->with('error', 'Izabrani tim nije učesnik ove utakmice.');
        }
        
        // Dobavljanje svih ID-ova tima (glavni tim + varijante)
        $sviIdTimova = [];
        
        // Ako je tim glavni tim, uzimamo i njegove varijante
        if ($tim->glavni_tim) {
            $sviIdTimova = $tim->getSviIdTimova();
        } 
        // Ako je tim varijanta (alias), uzimamo od matičnog tima sve varijante
        elseif ($tim->maticni_tim_id) {
            $maticniTim = Tim::find($tim->maticni_tim_id);
            if ($maticniTim) {
                $sviIdTimova = $maticniTim->getSviIdTimova();
            }
        }
        
        // Ako nismo našli povezane timove, koristimo samo ovaj tim
        if (empty($sviIdTimova)) {
            $sviIdTimova = [$tim_id];
        }
        
        // Igrači svih verzija tima
        $igraci = Igrac::whereIn('tim_id', $sviIdTimova)
                 ->orderBy('prezime')
                 ->orderBy('ime')
                 ->get();
        
        // Već dodati igrači u sastav
        $postojeciIgraciIds = Sastav::where('utakmica_id', $utakmica_id)
            ->where('tim_id', $tim_id)
            ->pluck('igrac_id')
            ->toArray();
        
        // Za dijagnostiku
        Log::debug('Tim ID: ' . $tim_id);
        Log::debug('Svi ID-ovi tima: ' . implode(', ', $sviIdTimova));
        Log::debug('Broj igrača: ' . $igraci->count());
        Log::debug('Postojeći igrači IDs: ' . implode(', ', $postojeciIgraciIds));
        
        return view('sastavi.create', compact('utakmica', 'tim', 'igraci', 'postojeciIgraciIds'));
    }

    /**
     * Čuvanje novog igrača u sastavu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'utakmica_id' => 'required|exists:utakmice,id',
            'tim_id' => 'required|exists:timovi,id',
            'igrac_id' => 'required|exists:igraci,id',
            'starter' => 'required|boolean',
            'selektor' => 'nullable|string|max:255',
        ]);

        // Provera da li igrač već postoji u sastavu
        $postojeciSastav = Sastav::where('utakmica_id', $validated['utakmica_id'])
            ->where('igrac_id', $validated['igrac_id'])
            ->first();
            
        if ($postojeciSastav) {
            return redirect()->back()
                ->with('error', 'Igrač je već dodat u sastav.');
        }

        $maxOrder = Sastav::where('utakmica_id', $validated['utakmica_id'])
            ->where('tim_id', $validated['tim_id'])
            ->max('redosled') ?? 0;

        $validated['redosled'] = $maxOrder + 1;

        Sastav::create($validated);

        return redirect()->route('sastavi.index', ['utakmica_id' => $validated['utakmica_id']])
            ->with('success', 'Igrač uspešno dodat.');
    }

    /**
     * Prikaz pojedinačnog igrača u sastavu.
     */
    public function show(Sastav $sastav)
    {
        $sastav->load(['utakmica', 'tim', 'igrac']);
        return view('sastavi.show', compact('sastav'));
    }

    /**
     * Prikaz forme za izmenu igrača u sastavu.
     */
    public function edit(Sastav $sastav)
    {
        $sastav->load(['utakmica', 'tim', 'igrac']);
        return view('sastavi.edit', compact('sastav'));
    }

    /**
     * Ažuriranje igrača u sastavu.
     */
    public function update(Request $request, Sastav $sastav)
    {
        $validated = $request->validate([
            'starter' => 'required|boolean',
            'selektor' => 'nullable|string|max:255',
        ]);

        $sastav->update($validated);

        return redirect()->route('sastavi.index', ['utakmica_id' => $sastav->utakmica_id])
            ->with('success', 'Igrač u sastavu uspešno ažuriran.');
    }

    /**
     * Brisanje igrača iz sastava.
     */
    public function destroy($id)
    {
        // Find the sastav record by ID
        $sastav = Sastav::findOrFail($id);
        
        // Store match ID before deletion
        $utakmica_id = $sastav->utakmica_id;
        
        // Delete the record
        $sastav->delete();
        
        // Redirect back to lineup page instead of match page
        return redirect()->route('sastavi.index', ['utakmica_id' => $utakmica_id])
            ->with('success', 'Igrač uspešno uklonjen iz sastava.');
    }

    public function updateOrder(Request $request)
    {
        try {
            \Log::info('Primljeni podaci:', ['request' => $request->all()]);
            
            $validated = $request->validate([
                'sastavi' => 'required|array',
                'sastavi.*.id' => 'required',
                'sastavi.*.redosled' => 'required|integer',
                'utakmica_id' => 'required|integer|exists:utakmice,id',
                'tim_tip' => 'required|string'
            ]);

            $utakmica_id = $validated['utakmica_id'];
            $updatedRegular = 0;
            $updatedOpponent = 0;
            
            foreach ($request->sastavi as $sastav) {
                // Provera da li je ID protivničkog igrača (počinje sa 'p')
                if (is_string($sastav['id']) && strpos($sastav['id'], 'p') === 0) {
                    $igracId = (int)substr($sastav['id'], 1);
                    
                    // Update protivničkog igrača
                    $igrac = \App\Models\ProtivnickiIgrac::find($igracId);
                    if ($igrac) {
                        \Log::info("Ažuriranje protivničkog igrača #{$igracId} na redosled {$sastav['redosled']}");
                        $igrac->redosled = $sastav['redosled'];
                        $igrac->save();
                        $updatedOpponent++;
                    }
                } else {
                    // Update regularnog igrača
                    $sastavId = (int)$sastav['id'];
                    $sastavModel = \App\Models\Sastav::find($sastavId);
                    if ($sastavModel) {
                        \Log::info("Ažuriranje sastavnog igrača #{$sastavId} na redosled {$sastav['redosled']}");
                        $sastavModel->redosled = $sastav['redosled'];
                        $sastavModel->save();
                        $updatedRegular++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Redosled uspešno ažuriran',
                'stats' => [
                    'regular' => $updatedRegular,
                    'opponent' => $updatedOpponent
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Greška: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
