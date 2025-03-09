@extends('layouts.app')

@section('title', 'Dodaj karton')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novi karton</h1>
    <a href="{{ route('kartoni.index', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-secondary">
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
                <div>
                    @if($utakmica->takmicenje)
                        {{ $utakmica->takmicenje->naziv }}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <h5>{{ $utakmica->gost->naziv }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Karton za tim: {{ $tim->naziv }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('kartoni.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="utakmica_id" value="{{ $utakmica->id }}">
            <input type="hidden" name="tim_id" value="{{ $tim->id }}">
            
            <div class="mb-3">
                <label for="igrac_id" class="form-label">Igrač *</label>
                <select class="form-select @error('igrac_id') is-invalid @enderror" 
                        id="igrac_id" name="igrac_id" required>
                    <option value="">-- Izaberite igrača --</option>
                    @foreach($igraci as $igrac)
                        <option value="{{ $igrac->id }}" {{ old('igrac_id') == $igrac->id ? 'selected' : '' }}>
                            {{ $igrac->ime }} {{ $igrac->prezime }}
                        </option>
                    @endforeach
                </select>
                @error('igrac_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="tip" class="form-label">Tip kartona *</label>
                <select class="form-select @error('tip') is-invalid @enderror" 
                        id="tip" name="tip" required>
                    <option value="">-- Izaberite tip kartona --</option>
                    <option value="zuti" {{ old('tip') == 'zuti' ? 'selected' : '' }}>Žuti karton</option>
                    <option value="crveni" {{ old('tip') == 'crveni' ? 'selected' : '' }}>Crveni karton</option>
                </select>
                @error('tip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="minut" class="form-label">Minut *</label>
                <input type="number" class="form-control @error('minut') is-invalid @enderror" 
                       id="minut" name="minut" value="{{ old('minut') }}" required min="1" max="120">
                @error('minut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj karton</button>
            </div>
        </form>
    </div>
</div>
@endsection