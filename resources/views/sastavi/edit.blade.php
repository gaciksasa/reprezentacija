@extends('layouts.app')

@section('title', 'Izmeni igrača u sastavu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni igrača u sastavu</h1>
    <a href="{{ route('utakmice.show', $sastav->utakmica_id) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Detalji utakmice</h5>
    </div>
    <div class="card-body">
        @if($sastav->utakmica)
        <div class="row align-items-center">
            <div class="col-md-4 text-md-end">
                <h5>{{ $sastav->utakmica->domacin->naziv }}</h5>
            </div>
            <div class="col-md-4 text-center">
                <div class="display-5">{{ $sastav->utakmica->rezultat_domacin }} - {{ $sastav->utakmica->rezultat_gost }}</div>
                <div class="text-muted">{{ $sastav->utakmica->datum->format('d.m.Y') }}</div>
                <div>
                    @if($sastav->utakmica->takmicenje)
                        {{ $sastav->utakmica->takmicenje->naziv }}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <h5>{{ $sastav->utakmica->gost->naziv }}</h5>
            </div>
        </div>
        @else
        <div class="alert alert-warning">
            Nije moguće učitati detalje utakmice.
        </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Izmeni igrača: {{ $sastav->igrac->ime_prezime ?? 'Nepoznat igrač' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('/sastavi/'.$sastav->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="starter" name="starter" value="1" {{ old('starter', $sastav->starter) ? 'checked' : '' }}>
                    <label class="form-check-label" for="starter">
                        Starter (igrač u startnoj postavi)
                    </label>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="kapiten" name="kapiten" value="1" {{ old('kapiten', $sastav->kapiten ?? false) ? 'checked' : '' }}>
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