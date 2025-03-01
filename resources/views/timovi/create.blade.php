@extends('layouts.app')

@section('title', 'Dodaj tim')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novi tim</h1>
    <a href="{{ route('timovi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('timovi.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="naziv" class="form-label">Naziv tima *</label>
                <input type="text" class="form-control @error('naziv') is-invalid @enderror" 
                       id="naziv" name="naziv" value="{{ old('naziv') }}" required>
                @error('naziv')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="skraceni_naziv" class="form-label">Skraćeni naziv</label>
                <input type="text" class="form-control @error('skraceni_naziv') is-invalid @enderror" 
                       id="skraceni_naziv" name="skraceni_naziv" value="{{ old('skraceni_naziv') }}">
                @error('skraceni_naziv')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="zemlja" class="form-label">Zemlja *</label>
                <input type="text" class="form-control @error('zemlja') is-invalid @enderror" 
                       id="zemlja" name="zemlja" value="{{ old('zemlja') }}" required>
                @error('zemlja')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="zastava_url" class="form-label">URL zastave</label>
                <input type="text" class="form-control @error('zastava_url') is-invalid @enderror" 
                       id="zastava_url" name="zastava_url" value="{{ old('zastava_url') }}">
                <small class="form-text text-muted">Unesite URL do slike zastave</small>
                @error('zastava_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="grb_url" class="form-label">URL grba</label>
                <input type="text" class="form-control @error('grb_url') is-invalid @enderror" 
                       id="grb_url" name="grb_url" value="{{ old('grb_url') }}">
                <small class="form-text text-muted">Unesite URL do slike grba</small>
                @error('grb_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj tim</button>
            </div>
        </form>
    </div>
</div>
@endsection