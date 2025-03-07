@extends('layouts.app')

@section('title', $tim->naziv)

@php
    // Dodaj funkciju za ispravno prikazivanje zastava ako helper nije dostupan
    if (!function_exists('zastava_url')) {
        function image_url($path, $default = 'img/no-image.png') {
            if (empty($path)) {
                return asset($default);
            }
            
            if (preg_match('/^https?:\/\//', $path)) {
                return $path;
            }
            
            if (strpos($path, 'storage/zastave/') === 0) {
                return asset($path);
            }
            
            return asset('storage/zastave/' . $path);
        }
    }

    // Dodaj funkciju za ispravno prikazivanje grbova ako helper nije dostupan
    if (!function_exists('grb_url')) {
        function image_url($path, $default = 'img/no-image.png') {
            if (empty($path)) {
                return asset($default);
            }
            
            if (preg_match('/^https?:\/\//', $path)) {
                return $path;
            }
            
            if (strpos($path, 'storage/grbovi/') === 0) {
                return asset($path);
            }
            
            return asset('storage/grbovi/' . $path);
        }
    }
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $tim->naziv }}</h1>
    <div>
        <a href="{{ route('timovi.edit', $tim) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
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
                    <img src="{{ image_url($tim->grb_url) }}" alt="{{ $tim->naziv }} grb" class="img-fluid mb-3" style="max-height: 150px;">
                @endif
                @if($tim->zastava_url)
                    <img src="{{ image_url($tim->zastava_url) }}" alt="{{ $tim->naziv }} zastava" class="img-fluid mb-3" style="max-height: 80px;">
                @endif
                <h4>{{ $tim->naziv }}</h4>
                @if($tim->skraceni_naziv)
                    <p class="text-muted">{{ $tim->skraceni_naziv }}</p>
                @endif
                <p><strong>Zemlja:</strong> {{ $tim->zemlja }}</p>
            </div>
        </div>
        
        <!-- Kartica za bilans protiv trenutnog tima -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Bilans protiv {{ $tim->naziv }}</h5>
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
                @endphp
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th class="text-center">Ut.</th>
                                <th class="text-center">Pob</th>
                                <th class="text-center">Ner</th>
                                <th class="text-center">Por</th>
                                <th class="text-center">Gol-raz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statistikaPotimovima as $naziv => $stats)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php
                                            // Dobavi zastavu za taj tim
                                            $alijasTim = \App\Models\Tim::where('naziv', $naziv)->first();
                                            $timZastava = $alijasTim ? $alijasTim->zastava_url : null;
                                        @endphp
                                        @if($timZastava)
                                            <img src="{{ image_url($timZastava) }}" alt="{{ $naziv }}" height="12" class="me-2">
                                        @endif
                                        {{ $naziv }}
                                    </div>
                                </td>
                                <td class="text-center">{{ $stats['ut'] }}</td>
                                <td class="text-center">{{ $stats['pob'] }}</td>
                                <td class="text-center">{{ $stats['ner'] }}</td>
                                <td class="text-center">{{ $stats['por'] }}</td>
                                <td class="text-center">{{ $stats['dati'] }} : {{ $stats['primljeni'] }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <td><strong>Ukupno</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['ut'] }}</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['pob'] }}</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['ner'] }}</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['por'] }}</strong></td>
                                <td class="text-center"><strong>{{ $ukupno['dati'] }} : {{ $ukupno['primljeni'] }}</strong></td>
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
                <h5 class="card-title mb-0">Utakmice</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="utakmiceTab" role="tablist">
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

                <div class="tab-content pt-3" id="utakmiceTabContent">
                    <div class="tab-pane fade show active" id="sve-utakmice" role="tabpanel">
                        @php
                            // Dobavi glavni tim (Srbija)
                            $glavniTim = \App\Models\Tim::glavniTim()->first();
                            
                            // Niz ID-ova našeg tima i svih njegovih alijasa
                            $nasTimIds = [];
                            if ($glavniTim) {
                                $nasTimIds = \App\Models\Tim::where('maticni_tim_id', $glavniTim->id)
                                            ->orWhere('id', $glavniTim->id)
                                            ->pluck('id')
                                            ->toArray();
                            }
                            
                            // Sve utakmice između našeg tima (i njegovih alijasa) i protivničkog tima
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
                        @endphp
                        
                        @if($sveUtakmice->count() > 0)
                            <div class="list-group">
                                @foreach($sveUtakmice as $utakmica)
                                    <a href="{{ route('utakmice.show', $utakmica) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $utakmica->domacin->naziv }}</strong> 
                                                {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }} 
                                                <strong>{{ $utakmica->gost->naziv }}</strong>
                                            </div>
                                            <small>{{ $utakmica->datum->format('d.m.Y') }}</small>
                                        </div>
                                        <small class="text-muted">{{ $utakmica->takmicenje->naziv }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih utakmica između ovih timova.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="domace-utakmice" role="tabpanel">
                        @php
                            // Utakmice gde je naš tim domaćin, a protivnik gost
                            $domaceUtakmice = \App\Models\Utakmica::with(['domacin', 'gost', 'takmicenje'])
                                ->whereIn('domacin_id', $nasTimIds ?? [])
                                ->where('gost_id', $tim->id)
                                ->orderBy('datum', 'desc')
                                ->get();
                        @endphp
                        
                        @if($domaceUtakmice->count() > 0)
                            <div class="list-group">
                                @foreach($domaceUtakmice as $utakmica)
                                    <a href="{{ route('utakmice.show', $utakmica) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $utakmica->domacin->naziv }}</strong> 
                                                {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }} 
                                                <strong>{{ $utakmica->gost->naziv }}</strong>
                                            </div>
                                            <small>{{ $utakmica->datum->format('d.m.Y') }}</small>
                                        </div>
                                        <small class="text-muted">{{ $utakmica->takmicenje->naziv }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih domaćih utakmica protiv ovog tima.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="gostujuce-utakmice" role="tabpanel">
                        @php
                            // Utakmice gde je naš tim gost, a protivnik domaćin
                            $gostujuceUtakmice = \App\Models\Utakmica::with(['domacin', 'gost', 'takmicenje'])
                                ->where('domacin_id', $tim->id)
                                ->whereIn('gost_id', $nasTimIds ?? [])
                                ->orderBy('datum', 'desc')
                                ->get();
                        @endphp
                        
                        @if($gostujuceUtakmice->count() > 0)
                            <div class="list-group">
                                @foreach($gostujuceUtakmice as $utakmica)
                                    <a href="{{ route('utakmice.show', $utakmica) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $utakmica->domacin->naziv }}</strong> 
                                                {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }} 
                                                <strong>{{ $utakmica->gost->naziv }}</strong>
                                            </div>
                                            <small>{{ $utakmica->datum->format('d.m.Y') }}</small>
                                        </div>
                                        <small class="text-muted">{{ $utakmica->takmicenje->naziv }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih gostujućih utakmica protiv ovog tima.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection