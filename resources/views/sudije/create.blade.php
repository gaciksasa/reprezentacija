@extends('layouts.app')

@section('title', 'Dodaj sudiju')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novu sudiju</h1>
    <a href="{{ route('sudije.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('sudije.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="ime" class="form-label">Ime *</label>
                <input type="text" class="form-control @error('ime') is-invalid @enderror" 
                       id="ime" name="ime" value="{{ old('ime') }}" required>
                @error('ime')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="prezime" class="form-label">Prezime *</label>
                <input type="text" class="form-control @error('prezime') is-invalid @enderror" 
                       id="prezime" name="prezime" value="{{ old('prezime') }}" required>
                @error('prezime')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="nacionalnost" class="form-label">Nacionalnost *</label>
                <input type="text" class="form-control @error('nacionalnost') is-invalid @enderror" 
                       id="nacionalnost" name="nacionalnost" value="{{ old('nacionalnost') }}" required>
                @error('nacionalnost')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj sudiju</button>
            </div>
        </form>
    </div>
</div>
@endsection