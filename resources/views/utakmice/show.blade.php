@extends('layouts.app')

@section('title', $utakmica->domacin->naziv . ' - ' . $utakmica->gost->naziv)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>
        <td>
            @if($utakmica->takmicenje)
                {{ $utakmica->takmicenje->naziv }}
            @endif
        </td>
    </h3>
    <div>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('utakmice.edit', $utakmica) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        @endif
        <a href="{{ route('utakmice.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<!-- Informacije o utakmici -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <strong>Datum:</strong> {{ $utakmica->datum->format('d.m.Y') }}
            </div>
            <div class="col-md-6">
                <strong>Stadion:</strong> {{ $utakmica->stadion }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <strong>Sudija:</strong> {{ $utakmica->sudija }}
            </div>
            <div class="col-md-6">
                <strong>Publika:</strong> {{ $utakmica->publika }}
            </div>
        </div>
    </div>
</div>

<!-- Sastavi -->
<div class="card mb-4">
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Sastavi</h5>
        <a href="{{ route('sastavi.index', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-primary">
            <i class="fas fa-users"></i> Upravljaj sastavima
        </a>  
    </div>
    @endif
    <div class="card-body">
        <div class="row py-4 align-items-center">
            <div class="col-4 text-center">
                <a href="{{ route('timovi.show', $utakmica->domacin) }}" class="text-decoration-none">
                    @if($utakmica->domacin && $utakmica->domacin->grb_url)
                        <img src="{{ asset('storage/grbovi/' . $utakmica->domacin->grb_url) }}" alt="{{ $utakmica->domacin->naziv }}" class="img-fluid mb-2" style="max-height: 100px;">
                    @endif
                    <h4><span class="text-danger fw-bold">{{ $utakmica->domacin->naziv }}</span></h4>
                </a>
            </div>
            <div class="col-4 text-center">
                <div class="text-muted">
                    {{ $utakmica->poluvremenskiRezultat }}
                </div>
                <div class="display-3 fw-bold">
                    {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}
                    @if($utakmica->imao_jedanaesterce)
                        <div class="fs-5 mt-1">
                            ({{ $utakmica->jedanaesterci_domacin }} - {{ $utakmica->jedanaesterci_gost }} pen)
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-4 text-center">
                <a href="{{ route('timovi.show', $utakmica->gost) }}" class="text-decoration-none">
                    @if($utakmica->gost && $utakmica->gost->grb_url)
                        <img src="{{ asset('storage/grbovi/' . $utakmica->gost->grb_url) }}" alt="{{ $utakmica->gost->naziv }}" class="img-fluid mb-2" style="max-height: 100px;">
                    @endif
                    <h4><span class="text-danger fw-bold">{{ $utakmica->gost->naziv }}</span></h4>
                </a>
            </div>
        </div>

        <!-- Sastavi -->
        <div class="row py-4 align-items-center">
            <div class="col-5 col-lg-4 text-end">
                @php
                    $domaciSastav = $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)->sortByDesc('starter');
                    $domaciProtivnickiIgraci = $utakmica->protivnickiIgraci->where('tim_id', $utakmica->domacin_id);
                    $imaDomacihIgraca = $domaciSastav->count() > 0 || $domaciProtivnickiIgraci->count() > 0;
                    
                    // Dobavi glavni tim (izabrani tim)
                    $glavniTim = \App\Models\Tim::glavniTim()->first();
                    $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
                    $domacinJeNasTim = in_array($utakmica->domacin_id, $glavniTimIds);
                @endphp
                @if($imaDomacihIgraca)
                    <ul class="list-unstyled" id="domaci-sastav-lista" style="text-align: right">
                        @foreach($domaciSastav as $sastav)
                            <li class="py-1 sortable-item" data-id="{{ $sastav->id }}">
                                @if($sastav->starter)
                                    <div class="d-flex align-items-center" style="justify-content: flex-end;">
                                        <a href="{{ route('igraci.show', $sastav->igrac->id) }}" class="text-decoration-none">
                                            <span class="text-danger fw-bold">
                                                {{ $sastav->igrac->prezime }} {{ $sastav->igrac->ime }}
                                                <small class="text-muted">({{ $sastav->igrac->getBrojNastupaDoDatuma($utakmica->datum) }})</small>
                                            </span>
                                        </a>
                                        @if(Auth::check() && Auth::user()->hasEditAccess())
                                        <div class="handle ms-4" style="cursor: move; opacity: 0.5;"><i class="fas fa-grip-vertical"></i></div>                           
                                        <form action="{{ route('sastavi.destroy', $sastav->id) }}" method="POST" class="d-inline ms-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                @endif
                            </li>
                        @endforeach
                        
                        @foreach($domaciProtivnickiIgraci->where('u_sastavu', true) as $igrac)
                            <li class="py-1 sortable-item" data-id="p{{ $igrac->id }}">
                                <div class="d-flex align-items-center" style="justify-content: flex-end;">
                                    <span class="fw-bold">
                                        {{ $igrac->prezime }} {{ $igrac->ime }} 
                                        @if($igrac->kapiten) <small>(C)</small> @endif
                                    </span>
                                    @if(Auth::check() && Auth::user()->hasEditAccess())
                                    <div class="handle ms-4" style="cursor: move; opacity: 0.5;"><i class="fas fa-grip-vertical"></i></div>
                                    <form action="{{ route('protivnicki-igraci.destroy', $igrac->id) }}" method="POST" class="d-inline ms-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @endif 
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center text-muted">Nema evidentiranih igrača za domaći tim.</p>
                @endif
            </div>
            <div class="col-2 col-lg-4"></div>
            <div class="col-5 col-lg-4">
                @php
                    $gostujuciSastav = $utakmica->sastavi->where('tim_id', $utakmica->gost_id)->sortByDesc('starter');
                    $gostujuciProtivnickiIgraci = $utakmica->protivnickiIgraci->where('tim_id', $utakmica->gost_id);
                    $imaGostujucihIgraca = $gostujuciSastav->count() > 0 || $gostujuciProtivnickiIgraci->count() > 0;
                    $gostJeNasTim = in_array($utakmica->gost_id, $glavniTimIds);
                @endphp
                @if($imaGostujucihIgraca)
                    <ul class="list-unstyled" id="gostujuci-sastav-lista">
                        @foreach($gostujuciSastav as $sastav)
                            <li class="py-1 sortable-item" data-id="{{ $sastav->id }}">
                                @if($sastav->starter)
                                    <div class="d-flex align-items-center">
                                        @if(Auth::check() && Auth::user()->hasEditAccess())
                                        <form action="{{ route('sastavi.destroy', $sastav->id) }}" method="POST" class="d-inline me-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        <div class="handle me-4" style="cursor: move; opacity: 0.5;"><i class="fas fa-grip-vertical"></i></div>
                                        @endif
                                        <a href="{{ route('igraci.show', $sastav->igrac->id) }}" class="text-decoration-none">
                                            <span class="text-danger fw-bold">
                                                {{ $sastav->igrac->prezime }} {{ $sastav->igrac->ime }}
                                                <small class="text-muted">({{ $sastav->igrac->getBrojNastupaDoDatuma($utakmica->datum) }})</small>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                        
                        @foreach($gostujuciProtivnickiIgraci->where('u_sastavu', true) as $igrac)
                            <li class="py-1 sortable-item" data-id="p{{ $igrac->id }}">
                                <div class="d-flex align-items-center">
                                    @if(Auth::check() && Auth::user()->hasEditAccess())
                                    <form action="{{ route('protivnicki-igraci.destroy', $igrac->id) }}" method="POST" class="d-inline me-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    <div class="handle me-4" style="cursor: move; opacity: 0.5;"><i class="fas fa-grip-vertical"></i></div>
                                    @endif
                                    <span class="fw-bold">
                                        {{ $igrac->prezime }} {{ $igrac->ime }} 
                                        @if($igrac->kapiten) <small>(C)</small> @endif
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center text-muted">Nema evidentiranih igrača za gostujući tim.</p>
                @endif
            </div>
        </div>

        <!-- Selektori -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Selektor</h5>
                        <!-- Dugme za dodavanje selektora domaćeg tima -->
                        @php
                            // Proveri da li je domaćin naš tim
                            $glavniTim = \App\Models\Tim::glavniTim()->first();
                            $nasTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
                            $domacinJeNasTim = in_array($utakmica->domacin_id, $nasTimIds);
                            
                            // Dohvati selektora protivničkog tima ako postoji
                            $domacinSelektor = null;
                            if (!$domacinJeNasTim) {
                                $domacinSelektor = \App\Models\ProtivnickiSelektor::where('utakmica_id', $utakmica->id)
                                    ->where('tim_id', $utakmica->domacin_id)
                                    ->first();
                            }
                        @endphp
                        
                        @if(!$domacinJeNasTim)
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <a href="{{ route('protivnicki-selektori.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Dodaj
                            </a>
                            @endif
                        @endif
                    </div>
                    <div class="card-body">
                        @if($domacinJeNasTim && isset($selektor) && $selektor)
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">
                                        <a href="{{ route('selektori.show', $selektor->selektor) }}" class="text-decoration-none">
                                            <span class="text-danger fw-bold">{{ $selektor->selektor->ime_prezime }}</span>
                                        </a>
                                        @if($selektor->v_d_status)
                                            <span class="badge bg-warning text-dark">v.d.</span>
                                        @endif
                                    </h5>
                                    <p class="mb-0 text-muted">
                                        <small>Period: {{ $selektor->pocetak_mandata->format('d.m.Y') }} - 
                                        {{ $selektor->kraj_mandata ? $selektor->kraj_mandata->format('d.m.Y') : 'danas' }}</small>
                                    </p>
                                </div>
                            </div>
                        @elseif(!$domacinJeNasTim && $domacinSelektor)
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $domacinSelektor->ime_prezime }}</h5>
                                    @if($domacinSelektor->napomena)
                                        <p class="mb-0 text-muted"><small>{{ $domacinSelektor->napomena }}</small></p>
                                    @endif
                                </div>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <div class="btn-group">
                                    <a href="{{ route('protivnicki-selektori.edit', $domacinSelektor->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="document.getElementById('delete-selektor-{{ $domacinSelektor->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-selektor-{{ $domacinSelektor->id }}" 
                                          action="{{ route('protivnicki-selektori.destroy', $domacinSelektor->id) }}" 
                                          method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                                @endif
                            </div>
                        @elseif(isset($selektorIme) && $selektorIme)
                            <p class="mb-0">{{ $selektorIme }}</p>
                        @else
                            <p class="text-muted mb-0">Nema podataka o selektoru</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Selektor</h5>
                        <!-- Dugme za dodavanje selektora gostujućeg tima -->
                        @php
                            // Proveri da li je gost naš tim
                            $gostJeNasTim = in_array($utakmica->gost_id, $nasTimIds);
                            
                            // Dohvati selektora protivničkog tima ako postoji
                            $gostSelektor = null;
                            if (!$gostJeNasTim) {
                                $gostSelektor = \App\Models\ProtivnickiSelektor::where('utakmica_id', $utakmica->id)
                                    ->where('tim_id', $utakmica->gost_id)
                                    ->first();
                            }
                        @endphp
                        
                        @if(!$gostJeNasTim)
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <a href="{{ route('protivnicki-selektori.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Dodaj
                            </a>
                            @endif
                        @endif
                    </div>
                    <div class="card-body">
                        @if($gostJeNasTim && isset($selektor) && $selektor)
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">
                                        <a href="{{ route('selektori.show', $selektor->selektor) }}" class="text-decoration-none">
                                            <span class="text-danger fw-bold">{{ $selektor->selektor->ime_prezime }}</span>
                                        </a>
                                        @if($selektor->v_d_status)
                                            <span class="badge bg-warning text-dark">v.d.</span>
                                        @endif
                                    </h5>
                                    <p class="mb-0 text-muted">
                                        <small>Period: {{ $selektor->pocetak_mandata->format('d.m.Y') }} - 
                                        {{ $selektor->kraj_mandata ? $selektor->kraj_mandata->format('d.m.Y') : 'danas' }}</small>
                                    </p>
                                </div>
                            </div>
                        @elseif(!$gostJeNasTim && $gostSelektor)
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $gostSelektor->ime_prezime }}</h5>
                                    @if($gostSelektor->napomena)
                                        <p class="mb-0 text-muted"><small>{{ $gostSelektor->napomena }}</small></p>
                                    @endif
                                </div>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <div class="btn-group">
                                    <a href="{{ route('protivnicki-selektori.edit', $gostSelektor->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="document.getElementById('delete-selektor-{{ $gostSelektor->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @if(Auth::check() && Auth::user()->hasEditAccess())
                                    <form action="{{ url('protivnicki-igraci/'.$igrac->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endif
                            </div>
                        @elseif(isset($selektorIme) && $selektorIme)
                            <p class="mb-0">{{ $selektorIme }}</p>
                        @else
                            <p class="text-muted mb-0">Nema podataka o selektoru</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Golovi -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Golovi</h5>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('golovi.create', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Dodaj
        </a>
        @endif
    </div>
    <div class="card-body">
        @if($utakmica->golovi->count() > 0)
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3">{{ $utakmica->domacin->naziv }}</h6>
                    <ul class="list-group">
                    @php
                        // Predračunaj trenutni rezultat za svaki gol
                        $domaciGolovi = 0;
                        $gostGolovi = 0;
                        $goloviSaRezultatom = [];
                        
                        foreach($utakmica->golovi->sortBy('minut') as $g) {
                            // Dodaj gol na odgovarajuću stranu
                            if ($g->auto_gol) {
                                // Autogol ide na stranu protivničkog tima
                                if ($g->tim_id == $utakmica->domacin_id) {
                                    $gostGolovi++;
                                } else {
                                    $domaciGolovi++;
                                }
                            } else {
                                // Regularan gol
                                if ($g->tim_id == $utakmica->domacin_id) {
                                    $domaciGolovi++;
                                } else {
                                    $gostGolovi++;
                                }
                            }
                            
                            // Sačuvaj trenutni rezultat za ovaj gol
                            $g->trenutni_rezultat = $domaciGolovi . '-' . $gostGolovi;
                        }
                    @endphp

                    {{-- Golovi domaćeg tima i autogolovi domaćeg tima --}}
                    @foreach($utakmica->golovi->sortBy('minut') as $gol)
                        @if(($gol->tim_id == $utakmica->domacin_id))
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">{{ $gol->minut }}' </span>
                                    @if($gol->igrac_tip == 'protivnicki')
                                        {{-- Prikazujemo protivničkog igrača --}}
                                        @php 
                                            $protivnickiIgrac = \App\Models\ProtivnickiIgrac::find($gol->igrac_id);
                                        @endphp
                                        @if($protivnickiIgrac)
                                            @if($gol->penal)
                                                <strong>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</strong> (p)
                                            @elseif($gol->auto_gol)
                                                <strong>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</strong> (ag)
                                            @else
                                                <strong>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</strong>
                                            @endif
                                        @else
                                            <strong>Nepoznat igrač</strong>
                                        @endif
                                    @else
                                        {{-- Prikazujemo regularnog igrača --}}
                                        @if($gol->igrac)
                                            <a href="{{ route('igraci.show', $gol->igrac->id) }}" class="text-decoration-none">
                                                <span class="text-danger fw-bold">
                                                    @if($gol->penal)
                                                        {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }} (p)
                                                    @elseif($gol->auto_gol)
                                                        {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }} (ag)
                                                    @else
                                                        {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}
                                                    @endif
                                                </span>
                                            </a>
                                        @else
                                            <strong>Nepoznat igrač</strong>
                                        @endif
                                    @endif
                                </div>
                                <div>
                                    <span class="badge bg-primary rounded-pill">{{ $gol->trenutni_rezultat }}</span>
                                    @if(Auth::check() && Auth::user()->hasEditAccess())
                                    <form action="{{ route('golovi.destroy', $gol->id) }}" method="POST" class="d-inline ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </li>
                        @endif
                    @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3">{{ $utakmica->gost->naziv }}</h6>
                    <ul class="list-group">
                    {{-- Golovi gostujućeg tima i autogolovi gostujućeg tima --}}
                    @foreach($utakmica->golovi->sortBy('minut') as $gol)
                        @if(($gol->tim_id == $utakmica->gost_id))
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">{{ $gol->minut }}' </span>
                                    @if($gol->igrac_tip == 'protivnicki')
                                        {{-- Prikazujemo protivničkog igrača --}}
                                        @php 
                                            $protivnickiIgrac = \App\Models\ProtivnickiIgrac::find($gol->igrac_id);
                                        @endphp
                                        @if($protivnickiIgrac)
                                            @if($gol->penal)
                                                <strong>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</strong> (p)
                                            @elseif($gol->auto_gol)
                                                <strong>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</strong> (ag)
                                            @else
                                                <strong>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</strong>
                                            @endif
                                        @else
                                            <strong>Nepoznat igrač</strong>
                                        @endif
                                    @else
                                        {{-- Prikazujemo regularnog igrača --}}
                                        @if($gol->igrac)
                                            @if($gol->penal)
                                                <strong>{{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}</strong> (p)
                                            @elseif($gol->auto_gol)
                                                <strong>{{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}</strong> (ag)
                                            @else
                                                <strong>{{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}</strong>
                                            @endif
                                        @else
                                            <strong>Nepoznat igrač</strong>
                                        @endif
                                    @endif
                                </div>
                                <div>
                                    <span class="badge bg-primary rounded-pill">{{ $gol->trenutni_rezultat }}</span>
                                    @if(Auth::check() && Auth::user()->hasEditAccess())
                                    <form action="{{ route('golovi.destroy', $gol->id) }}" method="POST" class="d-inline ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </li>
                        @endif
                    @endforeach
                    </ul>
                </div>
            </div>
        @else
            <p class="text-center text-muted">Nema evidentiranih golova za ovu utakmicu.</p>
        @endif
    </div>
</div>

<!-- Izmene -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Izmene</h5>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <div class="btn-group">
            <a href="{{ route('izmene.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Domaćin
            </a>
            <a href="{{ route('izmene.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Gost
            </a>
        </div>
        @endif
    </div>
    <div class="card-body">
        @php
            // Dobavi sve izmene (i regularne i protivničke)
            $sveIzmene = $utakmica->izmene->concat($utakmica->protivnickeIzmene)->sortBy('minut');
            
            // Grupiši izmene po timu
            $domaceIzmene = $sveIzmene->where('tim_id', $utakmica->domacin_id);
            $gostujuceIzmene = $sveIzmene->where('tim_id', $utakmica->gost_id);
        @endphp
        
        @if($sveIzmene->count() > 0)
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3">{{ $utakmica->domacin->naziv }}</h6>
                    <ul class="list-group">
                        @foreach($domaceIzmene as $izmena)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">{{ $izmena->minut }}' </span>
                                    <i class="fas fa-arrow-right text-success"></i> 
                                    @if(get_class($izmena) === 'App\Models\Izmena')
                                        <a href="{{ route('igraci.show', $izmena->igracIn->id) }}" class="text-decoration-none">
                                            <span class="text-danger fw-bold">{{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}</span>
                                        </a>
                                    @else
                                        <strong>{{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}</strong>
                                    @endif
                                    <br>
                                    <span class="text-muted ps-4">
                                        <i class="fas fa-arrow-left text-danger"></i> 
                                        @if(get_class($izmena) === 'App\Models\Izmena')
                                            <a href="{{ route('igraci.show', $izmena->igracOut->id) }}" class="text-decoration-none">
                                                {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                            </a>
                                        @else
                                            {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                        @endif
                                    </span>
                                </div>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <form action="{{ route('izmene.destroy', $izmena->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3">{{ $utakmica->gost->naziv }}</h6>
                    <ul class="list-group">
                        @foreach($gostujuceIzmene as $izmena)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">{{ $izmena->minut }}' </span>
                                    <i class="fas fa-arrow-right text-success"></i> 
                                    @if(get_class($izmena) === 'App\Models\Izmena')
                                        <a href="{{ route('igraci.show', $izmena->igracIn->id) }}" class="text-decoration-none">
                                            <span class="text-danger fw-bold">{{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}</span>
                                        </a>
                                    @else
                                        <strong>{{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}</strong>
                                    @endif
                                    <br>
                                    <span class="text-muted ps-4">
                                        <i class="fas fa-arrow-left text-danger"></i> 
                                        @if(get_class($izmena) === 'App\Models\Izmena')
                                            <a href="{{ route('igraci.show', $izmena->igracOut->id) }}" class="text-decoration-none">
                                                <span class="text-danger fw-bold">{{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}</span>
                                            </a>
                                        @else
                                            {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                        @endif
                                    </span>
                                </div>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <form action="{{ route('izmene.destroy', $izmena->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <p class="text-center text-muted">Nema evidentiranih izmena za ovu utakmicu.</p>
        @endif
    </div>
</div>

<!-- Kartoni -->
<div class="card mb-4">
   <div class="card-header d-flex justify-content-between align-items-center">
       <h5 class="card-title mb-0">Kartoni</h5>
       <div class="btn-group">
           @php
               // Proveri da li je domaćin naš tim
               $glavniTim = \App\Models\Tim::glavniTim()->first();
               $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
               $domacinJeNasTim = in_array($utakmica->domacin_id, $glavniTimIds);
               $gostJeNasTim = in_array($utakmica->gost_id, $glavniTimIds);
           @endphp
           
           @if(Auth::check() && Auth::user()->hasEditAccess())
                @if($domacinJeNasTim)
                    <a href="{{ route('kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Domaćin
                    </a>
                @else
                    <a href="{{ route('protivnicki-kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Domaćin
                    </a>
                @endif
                
                @if($gostJeNasTim)
                    <a href="{{ route('kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Gost
                    </a>
                @else
                    <a href="{{ route('protivnicki-kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Gost
                    </a>
                @endif
           @endif
       </div>
   </div>
   <div class="card-body">
       @php
           // Grupiši kartone po timu
           $domaciKartoni = $utakmica->kartoni->where('tim_id', $utakmica->domacin_id)->sortBy('minut');
           $gostujuciKartoni = $utakmica->kartoni->where('tim_id', $utakmica->gost_id)->sortBy('minut');
           
           // Grupiši protivničke kartone po timu
           $domaciProtivnickiKartoni = $utakmica->protivnickiKartoni->where('tim_id', $utakmica->domacin_id)->sortBy('minut');
           $gostujuciProtivnickiKartoni = $utakmica->protivnickiKartoni->where('tim_id', $utakmica->gost_id)->sortBy('minut');
       @endphp
       
       @if($utakmica->kartoni->count() > 0 || $utakmica->protivnickiKartoni->count() > 0)
           <div class="row">
               <div class="col-md-6">
                   <h6 class="mb-3">{{ $utakmica->domacin->naziv }}</h6>
                   <ul class="list-group">
                       <!-- Regulatni kartoni -->
                       @foreach($domaciKartoni as $karton)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div>
                               <span class="text-muted">{{ $karton->minut }}' </span>
                               @if($karton->tip == 'zuti')
                                   <i class="fas fa-square text-warning"></i>
                               @elseif($karton->tip == 'crveni' && $karton->drugi_zuti)
                                   <i class="fas fa-square text-warning"></i><i class="fas fa-square text-danger ms-1"></i>
                               @else
                                   <i class="fas fa-square text-danger"></i>
                               @endif
                               
                               @if($domacinJeNasTim)
                                   <a href="{{ route('igraci.show', $karton->igrac) }}" class="text-decoration-none">
                                       <span class="text-danger fw-bold">{{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}</span>
                                   </a>
                               @else
                                   {{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}
                               @endif
                           </div>
                           @if(Auth::check() && Auth::user()->hasEditAccess())
                           <form action="{{ route('kartoni.destroy', $karton->id) }}" method="POST" class="d-inline">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                   <i class="fas fa-times"></i>
                               </button>
                           </form>
                           @endif
                       </li>
                       @endforeach
                       
                       <!-- Protivnički kartoni -->
                       @foreach($domaciProtivnickiKartoni as $karton)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div>
                               <span class="text-muted">{{ $karton->minut }}' </span>
                               @if($karton->tip == 'zuti')
                                   <i class="fas fa-square text-warning"></i>
                               @elseif($karton->tip == 'crveni' && $karton->drugi_zuti)
                                   <i class="fas fa-square text-warning"></i><i class="fas fa-square text-danger ms-1"></i>
                               @else
                                   <i class="fas fa-square text-danger"></i>
                               @endif
                               {{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}
                           </div>
                           @if(Auth::check() && Auth::user()->hasEditAccess())
                           <form action="{{ route('protivnicki-kartoni.destroy', $karton->id) }}" method="POST" class="d-inline">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                   <i class="fas fa-times"></i>
                               </button>
                           </form>
                           @endif
                       </li>
                       @endforeach
                       
                       @if($domaciKartoni->count() == 0 && $domaciProtivnickiKartoni->count() == 0)
                           <li class="list-group-item text-center text-muted">Nema evidentiranih kartona.</li>
                       @endif
                   </ul>
               </div>
               <div class="col-md-6">
                   <h6 class="mb-3">{{ $utakmica->gost->naziv }}</h6>
                   <ul class="list-group">
                       <!-- Regulatni kartoni -->
                       @foreach($gostujuciKartoni as $karton)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div>
                               <span class="text-muted">{{ $karton->minut }}' </span>
                               @if($karton->tip == 'zuti')
                                   <i class="fas fa-square text-warning"></i>
                               @elseif($karton->tip == 'crveni' && $karton->drugi_zuti)
                                   <i class="fas fa-square text-warning"></i><i class="fas fa-square text-danger ms-1"></i>
                               @else
                                   <i class="fas fa-square text-danger"></i>
                               @endif
                               
                               @if($gostJeNasTim)
                                   <a href="{{ route('igraci.show', $karton->igrac) }}" class="text-decoration-none">
                                       <span class="text-danger fw-bold">{{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}</span>
                                   </a>
                               @else
                                   {{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}
                               @endif
                           </div>
                           @if(Auth::check() && Auth::user()->hasEditAccess())
                           <form action="{{ route('kartoni.destroy', $karton->id) }}" method="POST" class="d-inline">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                   <i class="fas fa-times"></i>
                               </button>
                           </form>
                           @endif
                       </li>
                       @endforeach
                       
                       <!-- Protivnički kartoni -->
                       @foreach($gostujuciProtivnickiKartoni as $karton)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div>
                               <span class="text-muted">{{ $karton->minut }}' </span>
                               @if($karton->tip == 'zuti')
                                   <i class="fas fa-square text-warning"></i>
                               @elseif($karton->tip == 'crveni' && $karton->drugi_zuti)
                                   <i class="fas fa-square text-warning"></i><i class="fas fa-square text-danger ms-1"></i>
                               @else
                                   <i class="fas fa-square text-danger"></i>
                               @endif
                               {{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}
                           </div>
                           @if(Auth::check() && Auth::user()->hasEditAccess())
                           <form action="{{ route('protivnicki-kartoni.destroy', $karton->id) }}" method="POST" class="d-inline">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                   <i class="fas fa-times"></i>
                               </button>
                           </form>
                           @endif
                       </li>
                       @endforeach
                       
                       @if($gostujuciKartoni->count() == 0 && $gostujuciProtivnickiKartoni->count() == 0)
                           <li class="list-group-item text-center text-muted">Nema evidentiranih kartona.</li>
                       @endif
                   </ul>
               </div>
           </div>
       @else
           <p class="text-center text-muted">Nema evidentiranih kartona za ovu utakmicu.</p>
       @endif
   </div>
</div>
@endsection

@if(Auth::check() && Auth::user()->hasEditAccess())
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicijalizacija Sortable za domaći tim
        const domaciSastavEl = document.getElementById('domaci-sastav-lista');
        if (domaciSastavEl) {
            const domaciSortable = new Sortable(domaciSastavEl, {
                handle: '.handle',
                animation: 150,
                onEnd: function(evt) {
                    // Direktno pozovemo updateSortOrder nakon što se završi prevlačenje
                    updateSortOrder('domaci');
                }
            });
        }
        
        // Inicijalizacija Sortable za gostujući tim
        const gostujuciSastavEl = document.getElementById('gostujuci-sastav-lista');
        if (gostujuciSastavEl) {
            const gostujuciSortable = new Sortable(gostujuciSastavEl, {
                handle: '.handle',
                animation: 150,
                onEnd: function(evt) {
                    // Direktno pozovemo updateSortOrder nakon što se završi prevlačenje
                    updateSortOrder('gostujuci');
                }
            });
        }
        
        function updateSortOrder(timTip) {
            const listId = timTip + '-sastav-lista';
            const items = Array.from(document.querySelectorAll(`#${listId} .sortable-item`));
            
            // Jasno definisana konverzija u niz objekata sa novim redosledom
            const sastavi = items.map((item, index) => {
                return {
                    id: item.dataset.id,
                    redosled: index
                };
            });
            
            console.log('Ažuriranje redosleda', {
                timTip,
                sastavi: sastavi
            });
            
            // Indikator za operaciju u toku
            const indicator = document.createElement('div');
            indicator.className = 'alert alert-info position-fixed top-0 start-50 translate-middle-x mt-2';
            indicator.style.zIndex = '9999';
            indicator.innerHTML = 'Ažuriranje redosleda...';
            document.body.appendChild(indicator);
            
            // Priprema podataka za slanje
            const jsonData = {
                sastavi: sastavi,
                utakmica_id: {{ $utakmica->id }},
                tim_tip: timTip
            };
            
            // Slanje AJAX zahteva za ažuriranje redosleda
            fetch('{{ route("sastavi.updateOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Mrežna greška');
                }
                return response.json();
            })
            .then(data => {
                console.log('Odgovor sa servera:', data);
                
                if (data.success) {
                    indicator.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x mt-2';
                    indicator.innerHTML = 'Redosled uspešno ažuriran';
                } else {
                    throw new Error(data.message || 'Nepoznata greška');
                }
                
                setTimeout(() => {
                    indicator.remove();
                }, 2000);
            })
            .catch(error => {
                console.error('Greška pri ažuriranju redosleda:', error);
                indicator.className = 'alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-2';
                indicator.innerHTML = `Greška: ${error.message || 'Mrežna greška'}`;
                
                setTimeout(() => {
                    indicator.remove();
                }, 3000);
            });
        }
    });
</script>
@endsection
@endif