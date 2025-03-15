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
        <a href="{{ route('utakmice.edit', $utakmica) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
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
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0"></h5>
        <div class="btn-group">
            @php
                // Dobavi glavni tim (izabrani tim)
                $glavniTim = \App\Models\Tim::glavniTim()->first();
                $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
                
                // Proveri da li je domaći tim izabrani tim
                $domaciJeIzabraniTim = $glavniTim && (
                    $utakmica->domacin_id == $glavniTim->id || 
                    in_array($utakmica->domacin_id, $glavniTimIds)
                );
            @endphp

            @if($domaciJeIzabraniTim)
                <a href="{{ route('sastavi.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Domaćin
                </a>
                <a href="{{ route('protivnicki-igraci.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Gost
                </a>
            @else
                <a href="{{ route('protivnicki-igraci.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Domaćin
                </a>
                <a href="{{ route('sastavi.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Gost
                </a>
            @endif
        </div>
    </div>
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
                <div class="display-3 fw-bold">{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</div>
                <div class="text-muted">
                    {{ $utakmica->poluvremenskiRezultat }}
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
            <div class="col-4 text-end">
                @php
                    $domaciSastav = $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)->sortByDesc('starter');
                    $domaciProtivnickiIgraci = $utakmica->protivnickiIgraci->where('tim_id', $utakmica->domacin_id);
                    $imaDomacihIgraca = $domaciSastav->count() > 0 || $domaciProtivnickiIgraci->count() > 0;
                @endphp
                @if($imaDomacihIgraca)
                    <ul class="list-unstyled">
                        @foreach($domaciSastav as $sastav)
                            <li class="py-1">
                                <a href="{{ route('igraci.show', $sastav->igrac->id) }}" class="text-decoration-none">
                                    <span class="text-danger {{ $sastav->starter ? 'fw-bold' : 'text-muted' }}">
                                        {{ $sastav->igrac->prezime }} {{ $sastav->igrac->ime }}
                                        @if(!$sastav->starter) <small>(rezerva)</small> @endif
                                    </span>
                                </a>
                                <form action="{{ route('sastavi.destroy', $sastav->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                        
                        @foreach($domaciProtivnickiIgraci->where('u_sastavu', true) as $igrac)
                            <li class="py-1">
                                <span class="fw-bold">
                                    {{ $igrac->prezime }} {{ $igrac->ime }} 
                                    @if($igrac->kapiten) <small>(C)</small> @endif
                                </span>
                                <form action="{{ route('protivnicki-igraci.destroy', $igrac->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center text-muted">Nema evidentiranih igrača za domaći tim.</p>
                @endif
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                @php
                    $gostujuciSastav = $utakmica->sastavi->where('tim_id', $utakmica->gost_id)->sortByDesc('starter');
                    $gostujuciProtivnickiIgraci = $utakmica->protivnickiIgraci->where('tim_id', $utakmica->gost_id);
                    $imaGostujucihIgraca = $gostujuciSastav->count() > 0 || $gostujuciProtivnickiIgraci->count() > 0;
                @endphp
                @if($imaGostujucihIgraca)
                    <ul class="list-unstyled">
                        @foreach($gostujuciSastav as $sastav)
                            <li class="py-1">
                            <form action="{{ route('sastavi.destroy', $sastav->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                <a href="{{ route('igraci.show', $sastav->igrac->id) }}" class="text-decoration-none">
                                    <span class="text-danger {{ $sastav->starter ? 'fw-bold' : 'text-muted' }}">
                                        {{ $sastav->igrac->prezime }} {{ $sastav->igrac->ime }} 
                                        @if(!$sastav->starter) <small>(rezerva)</small> @endif
                                    </span>
                                </a>
                            </li>
                        @endforeach
                        
                        @foreach($gostujuciProtivnickiIgraci->where('u_sastavu', true) as $igrac)
                            <li class="py-1">
                                <form action="{{ route('protivnicki-igraci.destroy', $igrac->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                <span class="fw-bold">
                                    {{ $igrac->prezime }} {{ $igrac->ime }} 
                                    @if($igrac->kapiten) <small>(C)</small> @endif
                                </span>
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
                        <h5 class="card-title mb-0">Selektor {{ $utakmica->domacin->naziv }}</h5>
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
                            <a href="{{ route('protivnicki-selektori.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Dodaj
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($domacinJeNasTim && isset($selektor) && $selektor)
                            <div class="d-flex align-items-center">
                                @if($selektor->selektor->fotografija_path)
                                    <div class="me-3">
                                        <img src="{{ asset('storage/' . $selektor->selektor->fotografija_path) }}" alt="{{ $selektor->selektor->ime_prezime }}" class="img-thumbnail" style="max-height: 80px">
                                    </div>
                                @endif
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
                        <h5 class="card-title mb-0">Selektor {{ $utakmica->gost->naziv }}</h5>
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
                            <a href="{{ route('protivnicki-selektori.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Dodaj
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($gostJeNasTim && isset($selektor) && $selektor)
                            <div class="d-flex align-items-center">
                                @if($selektor->selektor->fotografija_path)
                                    <div class="me-3">
                                        <img src="{{ asset('storage/' . $selektor->selektor->fotografija_path) }}" alt="{{ $selektor->selektor->ime_prezime }}" class="img-thumbnail" style="max-height: 80px">
                                    </div>
                                @endif
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
                                <div class="btn-group">
                                    <a href="{{ route('protivnicki-selektori.edit', $gostSelektor->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="document.getElementById('delete-selektor-{{ $gostSelektor->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form action="{{ url('protivnicki-igraci/'.$igrac->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
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
        <a href="{{ route('golovi.create', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Dodaj
        </a>
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
                                                        <strong>{{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}</strong> (p)
                                                    @elseif($gol->auto_gol)
                                                        <strong>{{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}</strong> (ag)
                                                    @else
                                                        <strong>{{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}</strong>
                                                    @endif
                                                </span>
                                            </a>
                                        @else
                                            <strong>Nepoznat igrač</strong>
                                        @endif
                                    @endif
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $gol->trenutni_rezultat }}</span>
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
                                <span class="badge bg-primary rounded-pill">{{ $gol->trenutni_rezultat }}</span>
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
        <div class="btn-group">
            <a href="{{ route('izmene.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Domaćin
            </a>
            <a href="{{ route('izmene.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Gost
            </a>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="izmeneTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="domaci-tab" data-bs-toggle="tab" data-bs-target="#domaci-izmene" type="button" role="tab" aria-controls="domaci-izmene" aria-selected="true">
                    {{ $utakmica->domacin->naziv }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="gostujuci-tab" data-bs-toggle="tab" data-bs-target="#gostujuci-izmene" type="button" role="tab" aria-controls="gostujuci-izmene" aria-selected="false">
                    {{ $utakmica->gost->naziv }}
                </button>
            </li>
        </ul>
        
        <div class="tab-content mt-3" id="izmeneTabContent">
            <!-- Izmene domaćeg tima -->
            <div class="tab-pane fade show active" id="domaci-izmene" role="tabpanel" aria-labelledby="domaci-tab">
                @php
                    // Prvo pripremamo posebne kolekcije za regularne i protivničke izmene
                    $domaciRegularneIzmene = $utakmica->izmene->where('tim_id', $utakmica->domacin_id)->values();
                    $domaciProtivnickeIzmene = $utakmica->protivnickeIzmene->where('tim_id', $utakmica->domacin_id)->values();
                @endphp

                @if($domaciRegularneIzmene->count() > 0 || $domaciProtivnickeIzmene->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Min</th>
                                    <th>Igrač koji ulazi</th>
                                    <th>Igrač koji izlazi</th>
                                    <th>Akcije</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($domaciRegularneIzmene->sortBy('minut') as $izmena)
                                <tr>
                                    <td>{{ $izmena->minut }}'</td>
                                    <td>
                                        <i class="fas fa-arrow-right text-success"></i> 
                                        {{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}
                                    </td>
                                    <td>
                                        <i class="fas fa-arrow-left text-danger"></i> 
                                        {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('izmene.edit', $izmena->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="document.getElementById('delete-regularna-izmena-{{ $izmena->id }}').submit()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-regularna-izmena-{{ $izmena->id }}" action="{{ route('izmene.destroy', $izmena->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @foreach($domaciProtivnickeIzmene->sortBy('minut') as $izmena)
                                <tr>
                                    <td>{{ $izmena->minut }}'</td>
                                    <td>
                                        <i class="fas fa-arrow-right text-success"></i> 
                                        {{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}
                                    </td>
                                    <td>
                                        <i class="fas fa-arrow-left text-danger"></i> 
                                        {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ url('protivnicke-izmene/'.$izmena->id.'/edit') }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="document.getElementById('delete-protivnicka-izmena-{{ $izmena->id }}').submit()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-protivnicka-izmena-{{ $izmena->id }}" action="{{ url('protivnicke-izmene/'.$izmena->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Nema evidentiranih izmena za domaći tim.</p>
                @endif
            </div>
            
            <!-- Izmene gostujućeg tima -->
            <div class="tab-pane fade" id="gostujuci-izmene" role="tabpanel" aria-labelledby="gostujuci-tab">
                @php
                    // Prvo pripremamo posebne kolekcije za regularne i protivničke izmene
                    $gostRegularneIzmene = $utakmica->izmene->where('tim_id', $utakmica->gost_id)->values();
                    $gostProtivnickeIzmene = $utakmica->protivnickeIzmene->where('tim_id', $utakmica->gost_id)->values();
                @endphp

                @if($gostRegularneIzmene->count() > 0 || $gostProtivnickeIzmene->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Min</th>
                                    <th>Igrač koji ulazi</th>
                                    <th>Igrač koji izlazi</th>
                                    <th>Akcije</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gostRegularneIzmene->sortBy('minut') as $izmena)
                                <tr>
                                    <td>{{ $izmena->minut }}'</td>
                                    <td>
                                        <i class="fas fa-arrow-right text-success"></i> 
                                        {{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}
                                    </td>
                                    <td>
                                        <i class="fas fa-arrow-left text-danger"></i> 
                                        {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('izmene.edit', $izmena->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="document.getElementById('delete-regularna-izmena-{{ $izmena->id }}').submit()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-regularna-izmena-{{ $izmena->id }}" action="{{ route('izmene.destroy', $izmena->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @foreach($gostProtivnickeIzmene->sortBy('minut') as $izmena)
                                <tr>
                                    <td>{{ $izmena->minut }}'</td>
                                    <td>
                                        <i class="fas fa-arrow-right text-success"></i> 
                                        {{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}
                                    </td>
                                    <td>
                                        <i class="fas fa-arrow-left text-danger"></i> 
                                        {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ url('protivnicke-izmene/'.$izmena->id.'/edit') }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="document.getElementById('delete-protivnicka-izmena-{{ $izmena->id }}').submit()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-protivnicka-izmena-{{ $izmena->id }}" action="{{ url('protivnicke-izmene/'.$izmena->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Nema evidentiranih izmena za gostujući tim.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Kartoni -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Kartoni</h5>
        <div class="btn-group">
            <a href="{{ route('kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Domaćin
            </a>
            <a href="{{ route('kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Gost
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($utakmica->kartoni->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Min</th>
                            <th>Tim</th>
                            <th>Igrač</th>
                            <th>Karton</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($utakmica->kartoni->sortBy('minut') as $karton)
                        <tr>
                            <td>{{ $karton->minut }}'</td>
                            <td>{{ $karton->tim->skraceni_naziv ?? $karton->tim->naziv }}</td>
                            <td>{{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}</td>
                            <td>
                                @if($karton->tip == 'zuti')
                                    <span class="badge bg-warning">Žuti</span>
                                @else
                                    <span class="badge bg-danger">Crveni</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted">Nema evidentiranih kartona za ovu utakmicu.</p>
        @endif
    </div>
</div>
@endsection