@extends('layouts.app')

@section('title', 'Pretraga')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Pretraga</h1>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('pretraga') }}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" name="query" placeholder="Unesite pojam za pretragu..." value="{{ $query ?? '' }}">
                <button class="btn btn-primary" type="submit">Pretraži</button>
            </div>
        </form>
    </div>
</div>

@if(isset($query))
    <h4>Rezultati pretrage za: "{{ $query }}"</h4>
    
    @if(isset($timovi) && $timovi->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Timovi</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($timovi as $tim)
                        <a href="{{ route('timovi.show', $tim) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($tim->zastava_url)
                                        <img src="{{ $tim->zastava_url }}" alt="{{ $tim->naziv }}" height="20" class="me-2">
                                    @endif
                                    <strong>{{ $tim->naziv }}</strong>
                                    @if($tim->skraceni_naziv)
                                        <small>({{ $tim->skraceni_naziv }})</small>
                                    @endif
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $tim->zemlja }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    @if(isset($igraci) && $igraci->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Igrači</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($igraci as $igrac)
                        <a href="{{ route('igraci.show', $igrac) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $igrac->ime }} {{ $igrac->prezime }}</strong>
                                    @if($igrac->pozicija)
                                        <small>({{ $igrac->pozicija }})</small>
                                    @endif
                                </div>
                                <span class="badge bg-info rounded-pill">{{ $igrac->tim->naziv }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    @if(isset($utakmice) && $utakmice->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Utakmice</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($utakmice as $utakmica)
                        <a href="{{ route('utakmice.show', $utakmica) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $utakmica->domacin->naziv }}</strong> 
                                    {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }} 
                                    <strong>{{ $utakmica->gost->naziv }}</strong>
                                </div>
                                <div>
                                    <span class="badge bg-secondary">{{ $utakmica->datum->format('d.m.Y') }}</span>
                                    <span class="badge bg-primary">{{ $utakmica->takmicenje->naziv }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    @if((!isset($timovi) || $timovi->count() == 0) && 
        (!isset($igraci) || $igraci->count() == 0) && 
        (!isset($utakmice) || $utakmice->count() == 0))
        <div class="alert alert-info">
            Nema rezultata pretrage za upit "{{ $query }}".
        </div>
    @endif
@endif
@endsection