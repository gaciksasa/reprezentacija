@extends('layouts.app')

@section('title', $tim->naziv)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $tim->naziv }}</h1>
    <div>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('timovi.edit', $tim) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        @endif
        <a href="{{ route('timovi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                @if($tim->grb_url)
                    <img src="{{ grb_url($tim->grb_url) }}" alt="{{ $tim->naziv }} grb" class="img-fluid" style="max-height: 100px;">
                @endif
            </div>
        </div>
        
        <!-- Kartica za bilans  -->
        <div class="card mt-4">
            <div class="card-header">
                <h2 class="card-title mb-0">Bilans</h2>
            </div>
            <div class="card-body">
                @php
                    // Dobavi glavni tim (Srbija)
                    $glavniTim = \App\Models\Tim::glavniTim()->first();
                    
                    // Niz za čuvanje statističkih podataka po timovima
                    $statistikaPotimovima = [];
                    $ukupno = [
                        'ut' => 0,
                        'pob' => 0,
                        'ner' => 0,
                        'por' => 0,
                        'dati' => 0,
                        'primljeni' => 0
                    ];
                    
                    // Da li je ovo naš tim?
                    $isOurTeam = false;
                    $nasTimIds = [];
                    
                    if ($glavniTim) {
                        $nasTimIds = \App\Models\Tim::where('maticni_tim_id', $glavniTim->id)
                            ->orWhere('id', $glavniTim->id)
                            ->pluck('id')
                            ->toArray();
                        $isOurTeam = in_array($tim->id, $nasTimIds);
                    }
                    
                    if (!$isOurTeam) {
                        // Glavni tim i njegovi alijasi
                        if ($glavniTim) {
                            // Dobavi glavne historijske varijante/alijase tima
                            $alijasi = \App\Models\Tim::where('maticni_tim_id', $glavniTim->id)
                                    ->orWhere('id', $glavniTim->id)
                                    ->get();
                                    
                            foreach ($alijasi as $alijas) {
                                $stats = [
                                    'ut' => 0,
                                    'pob' => 0,
                                    'ner' => 0,
                                    'por' => 0,
                                    'dati' => 0,
                                    'primljeni' => 0
                                ];
                                
                                // Za domaće utakmice gde je naš tim (alijas) bio domaćin, a trenutni tim gost
                                $domaceUtakmice = \App\Models\Utakmica::where('domacin_id', $alijas->id)
                                                ->where('gost_id', $tim->id)
                                                ->get();
                                
                                // Za gostujuće utakmice gde je naš tim (alijas) bio gost, a trenutni tim domaćin
                                $gostujuceUtakmice = \App\Models\Utakmica::where('domacin_id', $tim->id)
                                                    ->where('gost_id', $alijas->id)
                                                    ->get();
                                
                                // Obračunaj pobede/neresene/poraze za domaće utakmice
                                foreach ($domaceUtakmice as $utakmica) {
                                    $stats['ut']++;
                                    $stats['dati'] += $utakmica->rezultat_domacin;
                                    $stats['primljeni'] += $utakmica->rezultat_gost;
                                    
                                    if ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                                        $stats['pob']++;
                                    } elseif ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                                        $stats['por']++;
                                    } else {
                                        $stats['ner']++;
                                    }
                                }
                                
                                // Obračunaj pobede/neresene/poraze za gostujuće utakmice
                                foreach ($gostujuceUtakmice as $utakmica) {
                                    $stats['ut']++;
                                    $stats['dati'] += $utakmica->rezultat_gost;
                                    $stats['primljeni'] += $utakmica->rezultat_domacin;
                                    
                                    if ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                                        $stats['pob']++;
                                    } elseif ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                                        $stats['por']++;
                                    } else {
                                        $stats['ner']++;
                                    }
                                }
                                
                                // Samo ako ima utakmica, dodaj statistiku za ovaj alijas
                                if ($stats['ut'] > 0) {
                                    $statistikaPotimovima[$alijas->naziv] = $stats;
                                    
                                    // Dodaj u ukupnu statistiku
                                    $ukupno['ut'] += $stats['ut'];
                                    $ukupno['pob'] += $stats['pob'];
                                    $ukupno['ner'] += $stats['ner'];
                                    $ukupno['por'] += $stats['por'];
                                    $ukupno['dati'] += $stats['dati'];
                                    $ukupno['primljeni'] += $stats['primljeni'];
                                }
                            }
                        }
                    } else {
                        // Ako je ovo naš tim, prikaži bilans samo ovog alijasa protiv svih protivnika
                        // Prikupljamo podatke o svim protivnicima
                        $stats = [
                            'ut' => 0,
                            'pob' => 0,
                            'ner' => 0,
                            'por' => 0,
                            'dati' => 0,
                            'primljeni' => 0
                        ];
                        
                        // Utakmice gde je ovaj alijas domaćin
                        $domaceUtakmice = $tim->domaceUtakmice()->get();
                        
                        foreach ($domaceUtakmice as $utakmica) {
                            $stats['ut']++;
                            $stats['dati'] += $utakmica->rezultat_domacin;
                            $stats['primljeni'] += $utakmica->rezultat_gost;
                            
                            if ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                                $stats['pob']++;
                            } elseif ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                                $stats['por']++;
                            } else {
                                $stats['ner']++;
                            }
                        }
                        
                        // Utakmice gde je ovaj alijas gost
                        $gostujuceUtakmice = $tim->gostujuceUtakmice()->get();
                        
                        foreach ($gostujuceUtakmice as $utakmica) {
                            $stats['ut']++;
                            $stats['dati'] += $utakmica->rezultat_gost;
                            $stats['primljeni'] += $utakmica->rezultat_domacin;
                            
                            if ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                                $stats['pob']++;
                            } elseif ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                                $stats['por']++;
                            } else {
                                $stats['ner']++;
                            }
                        }
                        
                        // Dodaj statistiku za trenutni tim
                        if ($stats['ut'] > 0) {
                            $statistikaPotimovima[$tim->naziv] = $stats;
                            
                            // Postavi ukupnu statistiku
                            $ukupno = $stats;
                        }
                    }
                @endphp
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Ut</th>
                                <th class="text-center">P</th>
                                <th class="text-center">N</th>
                                <th class="text-center">I</th>
                                <th class="text-center">+/-</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statistikaPotimovima as $naziv => $stats)
                            <tr>
                                <td>{{ $naziv }}</td>
                                <td class="text-center">{{ $stats['ut'] }}</td>
                                <td class="text-center">{{ $stats['pob'] }}</td>
                                <td class="text-center">{{ $stats['ner'] }}</td>
                                <td class="text-center">{{ $stats['por'] }}</td>
                                <td class="text-center text-nowrap">{{ $stats['dati'] }} : {{ $stats['primljeni'] }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <td><strong>Ukupno</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['ut'] }}</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['pob'] }}</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['ner'] }}</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['por'] }}</strong></td>
                                <td class="text-center text-nowrap"><strong>{{ $ukupno['dati'] }} : {{ $ukupno['primljeni'] }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Utakmice -->
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="utakmiceTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="sve-tab" data-bs-toggle="tab" data-bs-target="#sve-utakmice" type="button" role="tab">
                            Sve utakmice
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="domace-tab" data-bs-toggle="tab" data-bs-target="#domace-utakmice" type="button" role="tab">
                            Domaće
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gostujuce-tab" data-bs-toggle="tab" data-bs-target="#gostujuce-utakmice" type="button" role="tab">
                            Gostujuće
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content pt-3" id="utakmiceTabContent">
                    <div class="tab-pane fade show active" id="sve-utakmice" role="tabpanel">
                        @php
                            // Dobavi glavni tim (Srbija)
                            $glavniTim = \App\Models\Tim::glavniTim()->first();
                            $nasTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
                            $isOurTeam = in_array($tim->id, $nasTimIds);
                            
                            // Ako je ovo naš tim ili alijas, prikaži samo utakmice tog specifičnog tima
                            if ($isOurTeam) {
                                $sveUtakmice = $tim->domaceUtakmice()
                                    ->with(['domacin', 'gost', 'takmicenje'])
                                    ->orderBy('datum', 'desc')
                                    ->get()
                                    ->concat(
                                        $tim->gostujuceUtakmice()
                                            ->with(['domacin', 'gost', 'takmicenje'])
                                            ->orderBy('datum', 'desc')
                                            ->get()
                                    )
                                    ->sortByDesc('datum');
                            } else {
                                // Ako je protivnički tim, prikaži sve utakmice protiv našeg tima i svih alijasa
                                $sveUtakmice = \App\Models\Utakmica::with(['domacin', 'gost', 'takmicenje'])
                                    ->where(function($query) use ($nasTimIds, $tim) {
                                        // Naš tim je domaćin, protivnik je gost
                                        $query->whereIn('domacin_id', $nasTimIds)
                                            ->where('gost_id', $tim->id);
                                    })
                                    ->orWhere(function($query) use ($nasTimIds, $tim) {
                                        // Naš tim je gost, protivnik je domaćin
                                        $query->where('domacin_id', $tim->id)
                                            ->whereIn('gost_id', $nasTimIds);
                                    })
                                    ->orderBy('datum', 'desc')
                                    ->get();
                            }
                        @endphp
                        
                        @if($sveUtakmice->count() > 0)
                            <table class="table table-striped table-bordered" width="100%">
                                <tbody>
                                @foreach($sveUtakmice as $utakmica)
                                    <tr>
                                        <td>{{ $utakmica->datum->format('d.m.Y') }}</td>
                                        <td>{{ $utakmica->domacin->naziv }}</td> 
                                        <td>{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</td>
                                        <td>{{ $utakmica->gost->naziv }}</td>
                                        <td>
                                            <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih utakmica za ovaj tim.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="domace-utakmice" role="tabpanel">
                        @php
                            // Ako je ovo naš tim ili alijas, prikaži samo domaće utakmice tog specifičnog tima
                            if ($isOurTeam) {
                                $domaceUtakmice = $tim->domaceUtakmice()
                                    ->with(['domacin', 'gost', 'takmicenje'])
                                    ->orderBy('datum', 'desc')
                                    ->get();
                            } else {
                                // Ako je protivnički tim, prikaži sve utakmice gde je on domaćin a naš tim gost
                                $domaceUtakmice = \App\Models\Utakmica::with(['domacin', 'gost', 'takmicenje'])
                                    ->where('domacin_id', $tim->id)
                                    ->whereIn('gost_id', $nasTimIds)
                                    ->orderBy('datum', 'desc')
                                    ->get();
                            }
                        @endphp
                        
                        @if($domaceUtakmice->count() > 0)
                            <div class="list-group">
                                <table class="table table-striped table-bordered" width="100%">
                                    <tbody>
                                    @foreach($domaceUtakmice as $utakmica)
                                        <tr>
                                            <td>{{ $utakmica->datum->format('d.m.Y') }}</td>
                                            <td>{{ $utakmica->domacin->naziv }}</td> 
                                            <td>{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</td>
                                            <td>{{ $utakmica->gost->naziv }}</td>
                                            <td>
                                                <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih domaćih utakmica za ovaj tim.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="gostujuce-utakmice" role="tabpanel">
                        @php
                            // Ako je ovo naš tim ili alijas, prikaži samo gostujuće utakmice tog specifičnog tima
                            if ($isOurTeam) {
                                $gostujuceUtakmice = $tim->gostujuceUtakmice()
                                    ->with(['domacin', 'gost', 'takmicenje'])
                                    ->orderBy('datum', 'desc')
                                    ->get();
                            } else {
                                // Ako je protivnički tim, prikaži sve utakmice gde je on gost a naš tim domaćin
                                $gostujuceUtakmice = \App\Models\Utakmica::with(['domacin', 'gost', 'takmicenje'])
                                    ->whereIn('domacin_id', $nasTimIds)
                                    ->where('gost_id', $tim->id)
                                    ->orderBy('datum', 'desc')
                                    ->get();
                            }
                        @endphp
                        
                        @if($gostujuceUtakmice->count() > 0)
                            <table class="table table-striped table-bordered" width="100%">
                                <tbody>
                                @foreach($gostujuceUtakmice as $utakmica)
                                    <tr>
                                        <td>{{ $utakmica->datum->format('d.m.Y') }}</td>
                                        <td>{{ $utakmica->domacin->naziv }}</td> 
                                        <td>{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</td>
                                        <td>{{ $utakmica->gost->naziv }}</td>
                                        <td>
                                            <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih gostujućih utakmica za ovaj tim.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection