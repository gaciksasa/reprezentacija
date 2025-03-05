@extends('layouts.app')

@section('title', $utakmica->domacin->naziv . ' - ' . $utakmica->gost->naziv)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Detalji utakmice</h1>
    <div>
        <a href="{{ route('utakmice.edit', $utakmica) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        <a href="{{ route('utakmice.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ $utakmica->takmicenje->naziv }}</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-4 text-center">
                        <a href="{{ route('timovi.show', $utakmica->domacin) }}">
                            @if($utakmica->domacin && $utakmica->domacin->grb_url)
                                <img src="{{ $utakmica->domacin->grb_url }}" alt="{{ $utakmica->domacin->naziv }}" class="img-fluid mb-2 img-fluid mb-2" style="max-height: 80px;">
                            @endif
                            <h4>{{ $utakmica->domacin ? $utakmica->domacin->naziv : 'Nepoznat tim' }}</h4>
                        </a>
                    </div>
                    <div class="col-4 text-center">
                        <div class="display-4 fw-bold">{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</div>
                        @if($utakmica->poluvreme_rezultat_domacin !== null && $utakmica->poluvreme_rezultat_gost !== null)
                            <div class="text-muted">
                                ({{ $utakmica->poluvreme_rezultat_domacin }} - {{ $utakmica->poluvreme_rezultat_gost }})
                            </div>
                        @endif
                    </div>
                    <div class="col-4 text-center">
                        <a href="{{ route('timovi.show', $utakmica->gost) }}">
                            @if($utakmica->gost && $utakmica->gost->grb_url)
                                <img src="{{ $utakmica->gost->grb_url }}" alt="{{ $utakmica->gost->naziv }}" class="img-fluid mb-2" style="max-height: 80px;">
                            @endif
                            <h4>{{ $utakmica->gost ? $utakmica->gost->naziv : 'Nepoznat tim' }}</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Datum:</strong> {{ $utakmica->datum->format('d.m.Y') }}</p>
                        @if($utakmica->vreme)
                            <p><strong>Vreme:</strong> {{ $utakmica->vreme->format('H:i') }}</p>
                        @endif
                        @if($utakmica->stadion)
                            <p><strong>Stadion:</strong> {{ $utakmica->stadion->naziv }}, {{ $utakmica->stadion->grad }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($utakmica->sudija)
                            <p><strong>Sudija:</strong> {{ $utakmica->sudija->ime }} {{ $utakmica->sudija->prezime }}</p>
                        @endif
                        @if($utakmica->publika)
                            <p><strong>Publika:</strong> {{ $utakmica->publika }}</p>
                        @endif
                        @if($utakmica->sezona)
                            <p><strong>Sezona:</strong> {{ $utakmica->sezona }}</p>
                        @endif
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
                                @foreach($utakmica->golovi as $gol)
                                    @if(($gol->tim_id == $utakmica->domacin_id && !$gol->auto_gol) || 
                                        ($gol->tim_id == $utakmica->gost_id && $gol->auto_gol))
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $gol->igrac->ime }} {{ $gol->igrac->prezime }}
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $gol->minut }}'
                                                @if($gol->penal) (P) @endif
                                                @if($gol->auto_gol) (AG) @endif
                                            </span>
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
    </div>

    <div class="col-md-4">
        <!-- Sastavi -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Sastavi timova</h5>
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
                <ul class="nav nav-tabs" id="sastaviTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="domacin-tab" data-bs-toggle="tab" data-bs-target="#domacin" type="button" role="tab">
                            {{ $utakmica->domacin->naziv }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gost-tab" data-bs-toggle="tab" data-bs-target="#gost" type="button" role="tab">
                            {{ $utakmica->gost->naziv }}
                        </button>
                    </li>
                </ul>
                <div class="tab-content pt-3" id="sastaviTabContent">
                    <div class="tab-pane fade show active" id="domacin" role="tabpanel">
                        @php
                            $domaciSastav = $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)->sortByDesc('starter');
                        @endphp
                        @if($domaciSastav->count() > 0)
                            <ul class="list-group">
                                @foreach($domaciSastav as $sastav)
                                    <li class="list-group-item {{ $sastav->starter ? 'fw-bold' : 'text-muted' }}">
                                        {{ $sastav->igrac->broj_dresa ?? '-' }}. {{ $sastav->igrac->ime }} {{ $sastav->igrac->prezime }}
                                        @if(!$sastav->starter) <small>(rezerva)</small> @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih igrača za domaći tim.</p>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="gost" role="tabpanel">
                        @php
                            $gostujuciSastav = $utakmica->sastavi->where('tim_id', $utakmica->gost_id)->sortByDesc('starter');
                        @endphp
                        @if($gostujuciSastav->count() > 0)
                            <ul class="list-group">
                                @foreach($gostujuciSastav as $sastav)
                                    <li class="list-group-item {{ $sastav->starter ? 'fw-bold' : 'text-muted' }}">
                                        {{ $sastav->igrac->broj_dresa ?? '-' }}. {{ $sastav->igrac->ime }} {{ $sastav->igrac->prezime }}
                                        @if(!$sastav->starter) <small>(rezerva)</small> @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih igrača za gostujući tim.</p>
                        @endif
                    </div>
                </div>
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
                                @foreach($utakmica->izmene as $izmena)
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
                                @foreach($utakmica->kartoni as $karton)
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