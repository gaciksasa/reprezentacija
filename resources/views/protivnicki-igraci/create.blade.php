@extends('layouts.app')

@section('title', 'Dodaj protivničkog igrača')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dodaj protivničkog igrača</h2>
    <a href="{{ route('protivnicki-igraci.index', ['utakmica_id' => $utakmica->id, 'tim_id' => $tim->id]) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title mb-0">Detalji utakmice</h2>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4 text-md-end">
                <h1>{{ $utakmica->domacin->naziv }}</h1>
            </div>
            <div class="col-md-4 text-center">
                <div class="display-5">{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</div>
                <div class="text-muted">{{ $utakmica->datum->format('d.m.Y') }}</div>
                <div>
                @if($utakmica->takmicenje)
                    {{ $utakmica->takmicenje->naziv }}
                @endif
                </div>
            </div>
            <div class="col-md-4">
                <h1>{{ $utakmica->gost->naziv }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title mb-0">Novi igrač tima: {{ $tim->naziv }}</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('protivnicki-igraci.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="utakmica_id" value="{{ $utakmica->id }}">
            <input type="hidden" name="tim_id" value="{{ $tim->id }}">
            
            <div class="mb-3">
                <label for="ime_prezime" class="form-label">Ime i prezime *</label>
                <input type="text" class="form-control @error('ime_prezime') is-invalid @enderror" 
                    id="ime_prezime" name="ime_prezime" value="{{ old('ime_prezime') }}" required >
                @error('ime_prezime')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="kapiten" name="kapiten" value="1" {{ old('kapiten') ? 'checked' : '' }}>
                    <label class="form-check-label" for="kapiten">
                        Kapiten tima
                    </label>
                </div>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj igrača</button>
            </div>
        </form>
    </div>
</div>
@endsection