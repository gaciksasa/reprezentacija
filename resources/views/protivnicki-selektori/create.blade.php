@extends('layouts.app')

@section('title', 'Dodaj selektora protivničkog tima')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj selektora protivničkog tima</h1>
    <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Detalji utakmice</h5>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4 text-md-end">
                <h5>{{ $utakmica->domacin->naziv }}</h5>
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
                <h5>{{ $utakmica->gost->naziv }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Selektor tima: {{ $tim->naziv }}</h5>
    </div>
    <div class="card-body">
        @if(isset($postojeciSelektor))
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Već postoji selektor za ovaj tim: <strong>{{ $postojeciSelektor->ime_prezime }}</strong>
                <br>Unosom novog selektora zamenjujete postojećeg.
            </div>
        @endif

        <form action="{{ route('protivnicki-selektori.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="utakmica_id" value="{{ $utakmica->id }}">
            <input type="hidden" name="tim_id" value="{{ $tim->id }}">
            
            <div class="mb-3">
                <label for="ime_prezime" class="form-label">Ime i prezime selektora *</label>
                <input type="text" class="form-control @error('ime_prezime') is-invalid @enderror" 
                       id="ime_prezime" name="ime_prezime" value="{{ old('ime_prezime', $postojeciSelektor->ime_prezime ?? '') }}" required>
                @error('ime_prezime')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!--
            <div class="mb-3">
                <label for="napomena" class="form-label">Napomena</label>
                <textarea class="form-control @error('napomena') is-invalid @enderror" 
                          id="napomena" name="napomena" rows="3">{{ old('napomena', $postojeciSelektor->napomena ?? '') }}</textarea>
                @error('napomena')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            -->
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj selektora</button>
            </div>
        </form>
    </div>
</div>
@endsection