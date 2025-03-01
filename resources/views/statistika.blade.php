@extends('layouts.app')

@section('title', 'Statistika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Statistika</h1>
</div>

<div class="row">
    <!-- Takmičenja sa brojem utakmica -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Takmičenja</h5>
            </div>
            <div class="card-body">
                @if($takmicenjaBrojUtakmica->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Takmičenje</th>
                                    <th>Broj utakmica</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($takmicenjaBrojUtakmica as $takmicenje)
                                    <tr>
                                        <td>{{ $takmicenje->naziv }}</td>
                                        <td>{{ $takmicenje->broj_utakmica }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Nema podataka o takmičenjima.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Golovi po timu -->
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Golovi po timu</h5>
            </div>
            <div class="card-body">
                @if($goloviPoTimu->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tim</th>
                                    <th>Dati golovi</th>
                                    <th>Primljeni golovi</th>
                                    <th>Gol razlika</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($goloviPoTimu as $tim)
                                    <tr>
                                        <td>{{ $tim->naziv }}</td>
                                        <td>{{ $tim->dati_golovi }}</td>
                                        <td>{{ $tim->primljeni_golovi }}</td>
                                        <td>{{ $tim->dati_golovi - $tim->primljeni_golovi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Nema podataka o golovima.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Utakmice sa najviše golova -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Utakmice sa najviše golova</h5>
            </div>
            <div class="card-body">
                @if($utakmiceNajviseGolova->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Datum</th>
                                    <th>Domaćin</th>
                                    <th>Rezultat</th>
                                    <th>Gost</th>
                                    <th>Ukupno golova</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utakmiceNajviseGolova as $utakmica)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($utakmica->datum)->format('d.m.Y') }}</td>
                                        <td>{{ $utakmica->domacin_naziv }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('utakmice.show', $utakmica) }}">
                                                <strong>{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</strong>
                                            </a>
                                        </td>
                                        <td>{{ $utakmica->gost_naziv }}</td>
                                        <td>{{ $utakmica->ukupno_golova }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Nema podataka o utakmicama.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection