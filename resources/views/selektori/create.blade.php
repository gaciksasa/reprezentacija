@extends('layouts.app')

@section('title', 'Dodaj selektora')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novog selektora</h1>
    <a href="{{ route('selektori.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('selektori.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <h4 class="mb-3">Osnovni podaci</h4>
            
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
                    <label for="mesto_rodjenja" class="form-label">Mesto rođenja</label>
                    <input type="text" class="form-control @error('mesto_rodjenja') is-invalid @enderror" 
                           id="mesto_rodjenja" name="mesto_rodjenja" value="{{ old('mesto_rodjenja') }}">
                    @error('mesto_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_smrti" class="form-label">Datum smrti</label>
                    <input type="date" class="form-control @error('datum_smrti') is-invalid @enderror" 
                           id="datum_smrti" name="datum_smrti" value="{{ old('datum_smrti') }}">
                    @error('datum_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_smrti" class="form-label">Mesto smrti</label>
                    <input type="text" class="form-control @error('mesto_smrti') is-invalid @enderror" 
                           id="mesto_smrti" name="mesto_smrti" value="{{ old('mesto_smrti') }}">
                    @error('mesto_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="drzavljanstvo" class="form-label">Državljanstvo</label>
                <input type="text" class="form-control @error('drzavljanstvo') is-invalid @enderror" 
                       id="drzavljanstvo" name="drzavljanstvo" value="{{ old('drzavljanstvo') }}">
                @error('drzavljanstvo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="biografija" class="form-label">Biografija</label>
                <textarea class="form-control @error('biografija') is-invalid @enderror" 
                          id="biografija" name="biografija" rows="3">{{ old('biografija') }}</textarea>
                @error('biografija')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="fotografija" class="form-label">Fotografija</label>
                <input type="file" class="form-control @error('fotografija') is-invalid @enderror" 
                       id="fotografija" name="fotografija">
                @error('fotografija')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <hr>
            
            <h4 class="mb-3">Prvi mandat</h4>
            
            <div class="row">
                <div class="col-md-6 mb-3">
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
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pocetak_mandata" class="form-label">Početak mandata *</label>
                    <input type="date" class="form-control @error('pocetak_mandata') is-invalid @enderror" 
                           id="pocetak_mandata" name="pocetak_mandata" value="{{ old('pocetak_mandata') }}" required>
                    @error('pocetak_mandata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="kraj_mandata" class="form-label">Kraj mandata</label>
                    <input type="date" class="form-control @error('kraj_mandata') is-invalid @enderror" 
                           id="kraj_mandata" name="kraj_mandata" value="{{ old('kraj_mandata') }}">
                    <small class="form-text text-muted">Ostavite prazno ako je selektor trenutno aktivan</small>
                    @error('kraj_mandata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="v_d_status" name="v_d_status" value="1" {{ old('v_d_status') ? 'checked' : '' }}>
                    <label class="form-check-label" for="v_d_status">
                        Vršilac dužnosti (v.d.)
                    </label>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="napomena" class="form-label">Napomena</label>
                <textarea class="form-control @error('napomena') is-invalid @enderror" 
                          id="napomena" name="napomena" rows="3">{{ old('napomena') }}</textarea>
                @error('napomena')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj selektora</button>
            </div>
        </form>
    </div>
</div>
@endsection