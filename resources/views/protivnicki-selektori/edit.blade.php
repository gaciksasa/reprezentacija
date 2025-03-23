@extends('layouts.app')

@section('title', 'Izmeni selektora protivničkog tima')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni selektora protivničkog tima</h1>
    <a href="{{ route('utakmice.show', $selektor->utakmica) }}" class="btn btn-secondary">
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
                <h5>{{ $selektor->utakmica->domacin->naziv }}</h5>
            </div>
            <div class="col-md-4 text-center">
                <div class="display-5">{{ $selektor->utakmica->rezultat_domacin }} - {{ $selektor->utakmica->rezultat_gost }}</div>
                <div class="text-muted">{{ $selektor->utakmica->datum->format('d.m.Y') }}</div>
                <div>
                    @if($selektor->utakmica->takmicenje)
                        {{ $selektor->utakmica->takmicenje->naziv }}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <h5>{{ $selektor->utakmica->gost->naziv }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Izmeni selektora za tim: {{ $selektor->tim->naziv }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('protivnicki-selektori.update', $selektor) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="ime_prezime" class="form-label">Ime i prezime selektora *</label>
                <input type="text" class="form-control @error('ime_prezime') is-invalid @enderror" 
                       id="ime_prezime" name="ime_prezime" value="{{ old('ime_prezime', $selektor->ime_prezime) }}" required>
                @error('ime_prezime')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- 
            <div class="mb-3">
                <label for="napomena" class="form-label">Napomena</label>
                <textarea class="form-control @error('napomena') is-invalid @enderror" 
                          id="napomena" name="napomena" rows="3">{{ old('napomena', $selektor->napomena) }}</textarea>
                @error('napomena')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            -->
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>
@endsection