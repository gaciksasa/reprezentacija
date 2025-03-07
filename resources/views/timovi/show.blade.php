@extends('layouts.app')

@section('title', $tim->naziv)

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
                    <img src="{{ $tim->grb_url }}" alt="{{ $tim->naziv }} grb" class="img-fluid mb-3" style="max-height: 150px;">
                @endif
                @if($tim->zastava_url)
                    <img src="{{ $tim->zastava_url }}" alt="{{ $tim->naziv }} zastava" class="img-fluid mb-3" style="max-height: 80px;">
                @endif
                <h4>{{ $tim->naziv }}</h4>
                @if($tim->skraceni_naziv)
                    <p class="text-muted">{{ $tim->skraceni_naziv }}</p>
                @endif
                <p><strong>Zemlja:</strong> {{ $tim->zemlja }}</p>
                
                <!-- Dodao sam prikaz ID tima za lakše debugovanje -->
                <p class="text-muted"><small>ID tima: {{ $tim->id }}</small></p>
            </div>
        </div>
        
        <!-- Dodata kartica za bilans -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Bilans protiv {{ $tim->naziv }}</h5>
            </div>
            <div class="card-body">
                @php
                    // Dobavi glavni tim (Srbija)
                    $glavniTim = \App\Models\Tim::glavniTim()->first();
                    
                    // Ukoliko postoji glavni tim, prikupi sve njegove ID-ove
                    $nasTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
                    
                    // Početni brojači
                    $pobede = 0;
                    $neresene = 0;
                    $porazi = 0;
                    $datiGolovi = 0;
                    $primljeniGolovi = 0;
                    
                    // Za domaće utakmice gde je naš tim bio domaćin, a trenutni tim gost
                    $domaceUtakmice = \App\Models\Utakmica::whereIn('domacin_id', $nasTimIds)
                                    ->where('gost_id', $tim->id)
                                    ->get();
                    
                    // Za gostujuće utakmice gde je naš tim bio gost, a trenutni tim domaćin
                    $gostujuceUtakmice = \App\Models\Utakmica::where('domacin_id', $tim->id)
                                        ->whereIn('gost_id', $nasTimIds)
                                        ->get();
                    
                    // Obračunaj pobede/neresene/poraze za domaće utakmice
                    foreach ($domaceUtakmice as $utakmica) {
                        $datiGolovi += $utakmica->rezultat_domacin;
                        $primljeniGolovi += $utakmica->rezultat_gost;
                        
                        if ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                            $pobede++;
                        } elseif ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                            $porazi++;
                        } else {
                            $neresene++;
                        }
                    }
                    
                    // Obračunaj pobede/neresene/poraze za gostujuće utakmice
                    foreach ($gostujuceUtakmice as $utakmica) {
                        $datiGolovi += $utakmica->rezultat_gost;
                        $primljeniGolovi += $utakmica->rezultat_domacin;
                        
                        if ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                            $pobede++;
                        } elseif ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                            $porazi++;
                        } else {
                            $neresene++;
                        }
                    }
                    
                    $ukupnoUtakmica = $pobede + $neresene + $porazi;
                    $golRazlika = $datiGolovi - $primljeniGolovi;
                @endphp
                
                <div class="row text-center">
                    <div class="col-4">
                        <h5 class="text-success">{{ $pobede }}</h5>
                        <small>Pobede</small>
                    </div>
                    <div class="col-4">
                        <h5>{{ $neresene }}</h5>
                        <small>Nerešene</small>
                    </div>
                    <div class="col-4">
                        <h5 class="text-danger">{{ $porazi }}</h5>
                        <small>Porazi</small>
                    </div>
                </div>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-4">
                        <h5>{{ $ukupnoUtakmica }}</h5>
                        <small>Utakmice</small>
                    </div>
                    <div class="col-4">
                        <h5>{{ $datiGolovi }}:{{ $primljeniGolovi }}</h5>
                        <small>Golovi</small>
                    </div>
                    <div class="col-4">
                        <h5 class="{{ $golRazlika > 0 ? 'text-success' : ($golRazlika < 0 ? 'text-danger' : '') }}">
                            {{ $golRazlika > 0 ? '+' : '' }}{{ $golRazlika }}
                        </h5>
                        <small>Gol razlika</small>
                    </div>
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
                        @if(($tim->domaceUtakmice && $tim->domaceUtakmice->count() > 0) || 
                           ($tim->gostujuceUtakmice && $tim->gostujuceUtakmice->count() > 0))
                            <div class="list-group">
                                @if($tim->domaceUtakmice)
                                    @foreach($tim->domaceUtakmice->sortByDesc('datum') as $utakmica)
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
                                @endif
                                @if($tim->gostujuceUtakmice)
                                    @foreach($tim->gostujuceUtakmice->sortByDesc('datum') as $utakmica)
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
                                @endif
                            </div>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih utakmica za ovaj tim.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="domace-utakmice" role="tabpanel">
                        @if($tim->domaceUtakmice && $tim->domaceUtakmice->count() > 0)
                            <div class="list-group">
                                @foreach($tim->domaceUtakmice->sortByDesc('datum') as $utakmica)
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
                            <p class="text-center text-muted">Nema evidentiranih domaćih utakmica za ovaj tim.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="gostujuce-utakmice" role="tabpanel">
                        @if($tim->gostujuceUtakmice && $tim->gostujuceUtakmice->count() > 0)
                            <div class="list-group">
                                @foreach($tim->gostujuceUtakmice->sortByDesc('datum') as $utakmica)
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
                            <p class="text-center text-muted">Nema evidentiranih gostujućih utakmica za ovaj tim.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection