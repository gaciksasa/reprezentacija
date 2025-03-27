@extends('layouts.app')

@section('title', 'Početna')

@section('content')

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="card-title">Bilansi</h2>
                <p class="display-4">{{ $brojTimova }}</p>
                <a href="{{ route('timovi.index') }}" class="btn btn-light">Prikaži sve</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="card-title">Reprezentativci</h2>
                <p class="display-4">{{ $brojIgraca }}</p>
                <a href="{{ route('igraci.index') }}" class="btn btn-light">Prikaži sve</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="card-title">Utakmice</h2>
                <p class="display-4">{{ $brojUtakmica }}</p>
                <a href="{{ route('utakmice.index') }}" class="btn btn-light">Prikaži sve</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mb-0">Poslednje utakmice</h2>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($poslednjeUtakmice as $utakmica)
                    <a href="{{ route('utakmice.show', $utakmica) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $utakmica->domacin->naziv }}</strong> 
                                {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }} 
                                <strong>{{ $utakmica->gost->naziv }}</strong>
                            </div>
                            <small>{{ $utakmica->datum->format('d.m.Y') }}</small>
                        </div>
                        <small class="text-muted">
                            @if($utakmica->takmicenje)
                                {{ $utakmica->takmicenje->naziv }}
                            @endif
                        </small>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('utakmice.index') }}" class="btn btn-primary">Sve utakmice</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title mb-0">Najbolji strelci</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Igrač</th>
                                <th>Golovi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($strelci as $index => $strelac)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a href="{{ route('igraci.show', $strelac->id) }}">{{ $strelac->prezime }} {{ $strelac->ime }}</a></td>
                                <td class="text-end">{{ $strelac->broj_golova }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title mb-0">Najviše nastupa</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Igrač</th>
                                <th class="text-end">Nastupa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($najviseNastupa as $index => $igrac)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a href="{{ route('igraci.show', $igrac->id) }}">{{ $igrac->prezime }} {{ $igrac->ime }}</a></td>
                                <td class="text-end">{{ $igrac->broj_nastupa }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection