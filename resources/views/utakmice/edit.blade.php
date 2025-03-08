@extends('layouts.app')

@section('title', 'Izmeni utakmicu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni utakmicu</h1>
    <a href="{{ route('utakmice.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('utakmice.update', $utakmica) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum" class="form-label">Datum *</label>
                    <input type="date" class="form-control @error('datum') is-invalid @enderror" 
                           id="datum" name="datum" value="{{ old('datum', $utakmica->datum->format('Y-m-d')) }}" required>
                    @error('datum')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="takmicenje" class="form-label">Takmičenje *</label>
                <input type="text" class="form-control @error('takmicenje') is-invalid @enderror" 
                       id="takmicenje" name="takmicenje" value="{{ old('takmicenje', $utakmica->takmicenje->naziv) }}" required>
                @error('takmicenje')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="domacin_id" class="form-label">Domaćin *</label>
                    <select class="form-select @error('domacin_id') is-invalid @enderror" 
                            id="domacin_id" name="domacin_id" required>
                        <option value="">-- Izaberite domaći tim --</option>
                        @foreach($timovi as $tim)
                            <option value="{{ $tim->id }}" {{ old('domacin_id', $utakmica->domacin_id) == $tim->id ? 'selected' : '' }}>
                                {{ $tim->naziv }}
                            </option>
                        @endforeach
                    </select>
                    @error('domacin_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="gost_id" class="form-label">Gost *</label>
                    <select class="form-select @error('gost_id') is-invalid @enderror" 
                            id="gost_id" name="gost_id" required>
                        <option value="">-- Izaberite gostujući tim --</option>
                        @foreach($timovi as $tim)
                            <option value="{{ $tim->id }}" {{ old('gost_id', $utakmica->gost_id) == $tim->id ? 'selected' : '' }}>
                                {{ $tim->naziv }}
                            </option>
                        @endforeach
                    </select>
                    @error('gost_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="stadion" class="form-label">Stadion</label>
                <input type="text" class="form-control @error('stadion') is-invalid @enderror" 
                       id="stadion" name="stadion" value="{{ old('stadion', $utakmica->stadion) }}">
                @error('stadion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="sudija" class="form-label">Sudija</label>
                <input type="text" class="form-control @error('sudija') is-invalid @enderror" 
                       id="sudija" name="sudija" value="{{ old('sudija', $utakmica->sudija) }}">
                @error('sudija')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="publika" class="form-label">Publika</label>
                <input type="text" class="form-control @error('publika') is-invalid @enderror" 
                       id="publika" name="publika" value="{{ old('publika', $utakmica->publika) }}">
                @error('publika')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>

<div class="mt-4">
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Trenutni rezultat: {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Rezultat utakmice se automatski ažurira na osnovu unetih golova.
            </div>
            
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('golovi.create', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-primary">
                    <i class="fas fa-futbol"></i> Dodaj gol
                </a>
                <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i> Pogledaj detalje utakmice
                </a>
            </div>
        </div>
    </div>
</div>
@endsection