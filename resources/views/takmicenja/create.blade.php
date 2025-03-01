@extends('layouts.app')

@section('title', 'Dodaj takmičenje')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novo takmičenje</h1>
    <a href="{{ route('takmicenja.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('takmicenja.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="naziv" class="form-label">Naziv takmičenja *</label>
                <input type="text" class="form-control @error('naziv') is-invalid @enderror" 
                       id="naziv" name="naziv" value="{{ old('naziv') }}" required>
                @error('naziv')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="sezona" class="form-label">Sezona</label>
                <input type="text" class="form-control @error('sezona') is-invalid @enderror" 
                       id="sezona" name="sezona" value="{{ old('sezona') }}">
                <small class="form-text text-muted">Npr. "2020/21"</small>
                @error('sezona')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="organizator" class="form-label">Organizator</label>
                <input type="text" class="form-control @error('organizator') is-invalid @enderror" 
                       id="organizator" name="organizator" value="{{ old('organizator') }}">
                @error('organizator')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj takmičenje</button>
            </div>
        </form>
    </div>
</div>
@endsection