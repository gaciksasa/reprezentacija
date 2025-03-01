@extends('layouts.app')

@section('title', 'Početna')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Dobrodošli u sistem Reprezentacija</h1>
                <p class="card-text">Baza podataka fudbalskih reprezentacija i utakmica.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Timovi</h5>
                <p class="display-4">{{ $brojTimova }}</p>
                <a href="{{ route('timovi.index') }}" class="btn btn-light">Prikaži sve</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Igrači</h5>
                <p class="display-4">{{ $brojIgraca }}</p>
                <a href="{{ route('igraci.index') }}" class="btn btn-light">Prikaži sve</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Utakmice</h5>
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
                <h5 class="card-title mb-0">Poslednje utakmice</h5>
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
                        <small class="text-muted">{{ $utakmica->takmicenje->naziv }}</small>
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Najbolji strelci</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Igrač</th>
                                <th>Tim</th>
                                <th>Golovi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($strelci as $index => $strelac)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $strelac->ime }} {{ $strelac->prezime }}</td>
                                <td>{{ $strelac->tim }}</td>
                                <td>{{ $strelac->broj_golova }}</td>
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