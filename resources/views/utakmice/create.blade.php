@extends('layouts.app')

@section('title', 'Dodaj utakmicu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novu utakmicu</h1>
    <a href="{{ route('utakmice.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('utakmice.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum" class="form-label">Datum *</label>
                    <input type="date" class="form-control @error('datum') is-invalid @enderror" 
                           id="datum" name="datum" value="{{ old('datum') }}" required>
                    @error('datum')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="takmicenje" class="form-label">Takmičenje *</label>
                <input type="text" class="form-control @error('takmicenje') is-invalid @enderror" 
                       id="takmicenje" name="takmicenje" value="{{ old('takmicenje') }}" required>
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
                            <option value="{{ $tim->id }}" {{ old('domacin_id') == $tim->id ? 'selected' : '' }}>
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
                            <option value="{{ $tim->id }}" {{ old('gost_id') == $tim->id ? 'selected' : '' }}>
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
                       id="stadion" name="stadion" value="{{ old('stadion') }}">
                @error('stadion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="sudija" class="form-label">Sudija</label>
                <input type="text" class="form-control @error('sudija') is-invalid @enderror" 
                       id="sudija" name="sudija" value="{{ old('sudija') }}">
                @error('sudija')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="publika" class="form-label">Publika</label>
                <input type="text" class="form-control @error('publika') is-invalid @enderror" 
                       id="publika" name="publika" value="{{ old('publika') }}">
                @error('publika')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj utakmicu</button>
            </div>
        </form>
    </div>
</div>
@endsection