@extends('layouts.app')

@section('title', 'Dodaj igrača u sastav')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj igrača u sastav</h1>
    <a href="{{ route('sastavi.index', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-secondary">
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
                <div>{{ $utakmica->takmicenje->naziv }}</div>
            </div>
            <div class="col-md-4">
                <h5>{{ $utakmica->gost->naziv }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Dodaj igrača u sastav tima: {{ $tim->naziv }}</h5>
    </div>
    <div class="card-body">
        @if($igraci->count() > 0)
            <form action="{{ route('sastavi.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="utakmica_id" value="{{ $utakmica->id }}">
                <input type="hidden" name="tim_id" value="{{ $tim->id }}">
                
                <div class="mb-3">
                    <label for="igrac_id" class="form-label">Igrač *</label>
                    <select class="form-select @error('igrac_id') is-invalid @enderror" 
                            id="igrac_id" name="igrac_id" required>
                        <option value="">-- Izaberite igrača --</option>
                        @foreach($igraci as $igrac)
                            @if(!in_array($igrac->id, $postojeciIgraciIds))
                                <option value="{{ $igrac->id }}" {{ old('igrac_id') == $igrac->id ? 'selected' : '' }}>
                                    {{ $igrac->ime }} {{ $igrac->prezime }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('igrac_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="starter" name="starter" value="1" {{ old('starter', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="starter">
                            Starter (igrač u startnoj postavi)
                        </label>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="selektor" class="form-label">Selektor</label>
                    <input type="text" class="form-control @error('selektor') is-invalid @enderror" 
                           id="selektor" name="selektor" value="{{ old('selektor') }}">
                    @error('selektor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Sačuvaj igrača u sastavu</button>
                </div>
            </form>
        @else
            <div class="alert alert-warning">
                <p>Nema dostupnih igrača za ovaj tim koji već nisu u sastavu.</p>
                <a href="{{ route('igraci.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus"></i> Dodaj novog igrača
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
