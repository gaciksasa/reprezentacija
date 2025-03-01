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
                
                <div class="col-md-6 mb-3">
                    <label for="vreme" class="form-label">Vreme</label>
                    <input type="time" class="form-control @error('vreme') is-invalid @enderror" 
                           id="vreme" name="vreme" value="{{ old('vreme') }}">
                    @error('vreme')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="takmicenje_id" class="form-label">Takmičenje *</label>
                <select class="form-select @error('takmicenje_id') is-invalid @enderror" 
                        id="takmicenje_id" name="takmicenje_id" required>
                    <option value="">-- Izaberite takmičenje --</option>
                    @foreach($takmicenja as $takmicenje)
                        <option value="{{ $takmicenje->id }}" {{ old('takmicenje_id') == $takmicenje->id ? 'selected' : '' }}>
                            {{ $takmicenje->naziv }}
                            @if($takmicenje->sezona) ({{ $takmicenje->sezona }}) @endif
                        </option>
                    @endforeach
                </select>
                @error('takmicenje_id')
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
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="rezultat_domacin" class="form-label">Golovi domaćina</label>
                    <input type="number" class="form-control @error('rezultat_domacin') is-invalid @enderror" 
                           id="rezultat_domacin" name="rezultat_domacin" value="{{ old('rezultat_domacin', 0) }}" min="0">
                    @error('rezultat_domacin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="rezultat_gost" class="form-label">Golovi gosta</label>
                    <input type="number" class="form-control @error('rezultat_gost') is-invalid @enderror" 
                           id="rezultat_gost" name="rezultat_gost" value="{{ old('rezultat_gost', 0) }}" min="0">
                    @error('rezultat_gost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
            <div class="col-md-6 mb-3">
                    <label for="poluvreme_rezultat_gost" class="form-label">Golovi gosta (poluvreme)</label>
                    <input type="number" class="form-control @error('poluvreme_rezultat_gost') is-invalid @enderror" 
                           id="poluvreme_rezultat_gost" name="poluvreme_rezultat_gost" value="{{ old('poluvreme_rezultat_gost') }}" min="0">
                    @error('poluvreme_rezultat_gost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="stadion_id" class="form-label">Stadion</label>
                <select class="form-select @error('stadion_id') is-invalid @enderror" 
                        id="stadion_id" name="stadion_id">
                    <option value="">-- Izaberite stadion --</option>
                    @foreach($stadioni as $stadion)
                        <option value="{{ $stadion->id }}" {{ old('stadion_id') == $stadion->id ? 'selected' : '' }}>
                            {{ $stadion->naziv }}, {{ $stadion->grad }}
                        </option>
                    @endforeach
                </select>
                @error('stadion_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="sudija_id" class="form-label">Sudija</label>
                <select class="form-select @error('sudija_id') is-invalid @enderror" 
                        id="sudija_id" name="sudija_id">
                    <option value="">-- Izaberite sudiju --</option>
                    @foreach($sudije as $sudija)
                        <option value="{{ $sudija->id }}" {{ old('sudija_id') == $sudija->id ? 'selected' : '' }}>
                            {{ $sudija->ime }} {{ $sudija->prezime }}
                        </option>
                    @endforeach
                </select>
                @error('sudija_id')
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
            
            <div class="mb-3">
                <label for="sezona" class="form-label">Sezona</label>
                <input type="text" class="form-control @error('sezona') is-invalid @enderror" 
                       id="sezona" name="sezona" value="{{ old('sezona') }}">
                @error('sezona')
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