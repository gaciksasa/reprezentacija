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
            <div class="col-md-3">
                <strong>Datum:</strong> {{ $utakmica->datum->format('d.m.Y') }}
            </div>
            <div class="col-md-3">
                <strong>Stadion:</strong> {{ $utakmica->stadion }}
            </div>
            <div class="col-md-3">
                <strong>Sudija:</strong> {{ $utakmica->sudija }}
            </div>
            <div class="col-md-3">
                <strong>Publika:</strong> {{ $utakmica->publika }}
            </div>
        </div>
    </div>
</div>

<!-- Glavni prikaz utakmice -->
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
                <a href="{{ route('timovi.show', $utakmica->domacin) }}">
                    @if($utakmica->domacin && $utakmica->domacin->grb_url)
                        <img src="{{ asset('storage/grbovi/' . $utakmica->domacin->grb_url) }}" alt="{{ $utakmica->domacin->naziv }}" class="img-fluid mb-2" style="max-height: 100px;">
                    @endif
                    <h4>{{ $utakmica->domacin->naziv }}</h4>
                </a>
            </div>
            <div class="col-4 text-center">
                <div class="display-3 fw-bold">{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</div>
                <div class="text-muted">
                    {{ $utakmica->poluvremenskiRezultat }}
                </div>
            </div>
            <div class="col-4 text-center">
                <a href="{{ route('timovi.show', $utakmica->gost) }}">
                    @if($utakmica->gost && $utakmica->gost->grb_url)
                        <img src="{{ asset('storage/grbovi/' . $utakmica->gost->grb_url) }}" alt="{{ $utakmica->gost->naziv }}" class="img-fluid mb-2" style="max-height: 100px;">
                    @endif
                    <h4>{{ $utakmica->gost->naziv }}</h4>
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
                            <li class="py-1 {{ $sastav->starter ? 'fw-bold' : 'text-muted' }}">
                                {{ $sastav->igrac->prezime }} {{ $sastav->igrac->ime }}
                                @if(!$sastav->starter) <small>(rezerva)</small> @endif
                            </li>
                        @endforeach
                        
                        @foreach($domaciProtivnickiIgraci as $igrac)
                            <li class="py-1 fw-bold">
                                {{ $igrac->prezime }} {{ $igrac->ime }} 
                                @if($igrac->kapiten) <small>(C)</small> @endif
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
                            <li class="py-1 {{ $sastav->starter ? 'fw-bold' : 'text-muted' }}">
                                {{ $sastav->igrac->prezime }} {{ $sastav->igrac->ime }} 
                                @if(!$sastav->starter) <small>(rezerva)</small> @endif
                            </li>
                        @endforeach
                        
                        @foreach($gostujuciProtivnickiIgraci as $igrac)
                            <li class="py-1 fw-bold">
                                {{ $igrac->prezime }} {{ $igrac->ime }} 
                                @if($igrac->kapiten) <small>(C)</small> @endif
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
                                        <a href="{{ route('selektori.show', $selektor->selektor) }}">
                                            {{ $selektor->selektor->ime_prezime }}
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
                                        <a href="{{ route('selektori.show', $selektor->selektor) }}">
                                            {{ $selektor->selektor->ime_prezime }}
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
                                    <form id="delete-selektor-{{ $gostSelektor->id }}" 
                                          action="{{ route('protivnicki-selektori.destroy', $gostSelektor->id) }}" 
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
                                                <strong>{{ $protivnickiIgrac->ime }} {{ $protivnickiIgrac->prezime }}</strong> (p)
                                            @elseif($gol->auto_gol)
                                                <strong>{{ $protivnickiIgrac->ime }} {{ $protivnickiIgrac->prezime }}</strong> (ag)
                                            @else
                                                <strong>{{ $protivnickiIgrac->ime }} {{ $protivnickiIgrac->prezime }}</strong>
                                            @endif
                                        @else
                                            <strong>Nepoznat igrač</strong>
                                        @endif
                                    @else
                                        {{-- Prikazujemo regularnog igrača --}}
                                        @if($gol->igrac)
                                            @if($gol->penal)
                                                <strong>{{ $gol->igrac->ime }} {{ $gol->igrac->prezime }}</strong> (p)
                                            @elseif($gol->auto_gol)
                                                <strong>{{ $gol->igrac->ime }} {{ $gol->igrac->prezime }}</strong> (ag)
                                            @else
                                                <strong>{{ $gol->igrac->ime }} {{ $gol->igrac->prezime }}</strong>
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
                                                <strong>{{ $protivnickiIgrac->ime }} {{ $protivnickiIgrac->prezime }}</strong> (p)
                                            @elseif($gol->auto_gol)
                                                <strong>{{ $protivnickiIgrac->ime }} {{ $protivnickiIgrac->prezime }}</strong> (ag)
                                            @else
                                                <strong>{{ $protivnickiIgrac->ime }} {{ $protivnickiIgrac->prezime }}</strong>
                                            @endif
                                        @else
                                            <strong>Nepoznat igrač</strong>
                                        @endif
                                    @else
                                        {{-- Prikazujemo regularnog igrača --}}
                                        @if($gol->igrac)
                                            @if($gol->penal)
                                                <strong>{{ $gol->igrac->ime }} {{ $gol->igrac->prezime }}</strong> (p)
                                            @elseif($gol->auto_gol)
                                                <strong>{{ $gol->igrac->ime }} {{ $gol->igrac->prezime }}</strong> (ag)
                                            @else
                                                <strong>{{ $gol->igrac->ime }} {{ $gol->igrac->prezime }}</strong>
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

<div class="row">
    <div class="col-md-6">
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
                @if($utakmica->izmene->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Min</th>
                                    <th>Tim</th>
                                    <th>Izmena</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utakmica->izmene->sortBy('minut') as $izmena)
                                <tr>
                                    <td>{{ $izmena->minut }}'</td>
                                    <td>{{ $izmena->tim->skraceni_naziv ?? $izmena->tim->naziv }}</td>
                                    <td>
                                        <i class="fas fa-arrow-right text-success"></i> {{ $izmena->igracIn->ime }} {{ $izmena->igracIn->prezime }}<br>
                                        <i class="fas fa-arrow-left text-danger"></i> {{ $izmena->igracOut->ime }} {{ $izmena->igracOut->prezime }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Nema evidentiranih izmena za ovu utakmicu.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
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
                                    <td>{{ $karton->igrac->ime }} {{ $karton->igrac->prezime }}</td>
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
    </div>
</div>
@endsection