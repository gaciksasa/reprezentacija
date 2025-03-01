@extends('layouts.app')

@section('title', 'Dodaj igrača')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novog igrača</h1>
    <a href="{{ route('igraci.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('igraci.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ime" class="form-label">Ime *</label>
                    <input type="text" class="form-control @error('ime') is-invalid @enderror" 
                           id="ime" name="ime" value="{{ old('ime') }}" required>
                    @error('ime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="prezime" class="form-label">Prezime *</label>
                    <input type="text" class="form-control @error('prezime') is-invalid @enderror" 
                           id="prezime" name="prezime" value="{{ old('prezime') }}" required>
                    @error('prezime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="tim_id" class="form-label">Tim *</label>
                <select class="form-select @error('tim_id') is-invalid @enderror" 
                        id="tim_id" name="tim_id" required>
                    <option value="">-- Izaberite tim --</option>
                    @foreach($timovi as $tim)
                        <option value="{{ $tim->id }}" {{ old('tim_id') == $tim->id ? 'selected' : '' }}>
                            {{ $tim->naziv }}
                        </option>
                    @endforeach
                </select>
                @error('tim_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="broj_dresa" class="form-label">Broj dresa</label>
                    <input type="number" class="form-control @error('broj_dresa') is-invalid @enderror" 
                           id="broj_dresa" name="broj_dresa" value="{{ old('broj_dresa') }}" min="1">
                    @error('broj_dresa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="pozicija" class="form-label">Pozicija</label>
                    <input type="text" class="form-control @error('pozicija') is-invalid @enderror" 
                           id="pozicija" name="pozicija" value="{{ old('pozicija') }}">
                    @error('pozicija')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="klub" class="form-label">Klub</label>
                    <input type="text" class="form-control @error('klub') is-invalid @enderror" 
                           id="klub" name="klub" value="{{ old('klub') }}">
                    @error('klub')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="drzava_kluba" class="form-label">Država kluba</label>
                    <input type="text" class="form-control @error('drzava_kluba') is-invalid @enderror" 
                           id="drzava_kluba" name="drzava_kluba" value="{{ old('drzava_kluba') }}">
                    @error('drzava_kluba')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_rodjenja" class="form-label">Datum rođenja</label>
                    <input type="date" class="form-control @error('datum_rodjenja') is-invalid @enderror" 
                           id="datum_rodjenja" name="datum_rodjenja" value="{{ old('datum_rodjenja') }}">
                    @error('datum_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="nacionalnost" class="form-label">Nacionalnost</label>
                    <input type="text" class="form-control @error('nacionalnost') is-invalid @enderror" 
                           id="nacionalnost" name="nacionalnost" value="{{ old('nacionalnost') }}">
                    @error('nacionalnost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj igrača</button>
            </div>
        </form>
    </div>
</div>
@endsection