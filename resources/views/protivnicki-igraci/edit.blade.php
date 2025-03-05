@extends('layouts.app')

@section('title', 'Izmeni protivničkog igrača')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni protivničkog igrača</h1>
    <a href="{{ route('protivnicki-igraci.index', ['utakmica_id' => $protivnickiIgrac->utakmica_id, 'tim_id' => $protivnickiIgrac->tim_id]) }}" class="btn btn-secondary">
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
                <h5>{{ $protivnickiIgrac->utakmica->domacin->naziv }}</h5>
            </div>
            <div class="col-md-4 text-center">
                <div class="display-5">{{ $protivnickiIgrac->utakmica->rezultat_domacin }} - {{ $protivnickiIgrac->utakmica->rezultat_gost }}</div>
                <div class="text-muted">{{ $protivnickiIgrac->utakmica->datum->format('d.m.Y') }}</div>
                <div>{{ $protivnickiIgrac->utakmica->takmicenje->naziv }}</div>
            </div>
            <div class="col-md-4">
                <h5>{{ $protivnickiIgrac->utakmica->gost->naziv }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Izmeni igrača tima: {{ $protivnickiIgrac->tim->naziv }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('protivnicki-igraci.update', $protivnickiIgrac) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="ime" class="form-label">Ime *</label>
                <input type="text" class="form-control @error('ime') is-invalid @enderror" 
                       id="ime" name="ime" value="{{ old('ime', $protivnickiIgrac->ime) }}" required>
                @error('ime')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="prezime" class="form-label">Prezime *</label>
                <input type="text" class="form-control @error('prezime') is-invalid @enderror" 
                       id="prezime" name="prezime" value="{{ old('prezime', $protivnickiIgrac->prezime) }}" required>
                @error('prezime')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="kapiten" name="kapiten" value="1" {{ old('kapiten', $protivnickiIgrac->kapiten) ? 'checked' : '' }}>
                    <label class="form-check-label" for="kapiten">
                        Kapiten tima
                    </label>
                </div>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>
@endsection