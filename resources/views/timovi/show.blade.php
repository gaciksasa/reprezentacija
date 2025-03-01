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
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Igrači -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Igrači</h5>
                <a href="{{ route('igraci.create', ['tim_id' => $tim->id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Dodaj igrača
                </a>
            </div>
            <div class="card-body">
                @if($tim->igraci->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ime i prezime</th>
                                    <th>Pozicija</th>
                                    <th>Klub</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tim->igraci as $igrac)
                                <tr>
                                    <td>{{ $igrac->broj_dresa ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('igraci.show', $igrac) }}">
                                            {{ $igrac->ime }} {{ $igrac->prezime }}
                                        </a>
                                    </td>
                                    <td>{{ $igrac->pozicija ?? '-' }}</td>
                                    <td>
                                        @if($igrac->klub)
                                            {{ $igrac->klub }}
                                            @if($igrac->drzava_kluba)
                                                <small>({{ $igrac->drzava_kluba }})</small>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('igraci.show', $igrac) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Nema evidentiranih igrača za ovaj tim.</p>
                @endif
            </div>
        </div>

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
                        @if($tim->domaceUtakmice->count() > 0 || $tim->gostujuceUtakmice->count() > 0)
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
                            <p class="text-center text-muted">Nema evidentiranih utakmica za ovaj tim.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="domace-utakmice" role="tabpanel">
                        @if($tim->domaceUtakmice->count() > 0)
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
                        @if($tim->gostujuceUtakmice->count() > 0)
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