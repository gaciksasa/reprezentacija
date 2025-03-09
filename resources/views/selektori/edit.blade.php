@extends('layouts.app')

@section('title', 'Izmeni selektora - ' . $selektor->ime_prezime)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni selektora: {{ $selektor->ime_prezime }}</h1>
    <a href="{{ route('selektori.show', $selektor) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('selektori.update', $selektor) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <h4 class="mb-3">Osnovni podaci</h4>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ime" class="form-label">Ime *</label>
                    <input type="text" class="form-control @error('ime') is-invalid @enderror" 
                           id="ime" name="ime" value="{{ old('ime', $selektor->ime) }}" required>
                    @error('ime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="prezime" class="form-label">Prezime *</label>
                    <input type="text" class="form-control @error('prezime') is-invalid @enderror" 
                           id="prezime" name="prezime" value="{{ old('prezime', $selektor->prezime) }}" required>
                    @error('prezime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_rodjenja" class="form-label">Datum rođenja</label>
                    <input type="date" class="form-control @error('datum_rodjenja') is-invalid @enderror" 
                           id="datum_rodjenja" name="datum_rodjenja" 
                           value="{{ old('datum_rodjenja', $selektor->datum_rodjenja ? $selektor->datum_rodjenja->format('Y-m-d') : '') }}">
                    @error('datum_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_rodjenja" class="form-label">Mesto rođenja</label>
                    <input type="text" class="form-control @error('mesto_rodjenja') is-invalid @enderror" 
                           id="mesto_rodjenja" name="mesto_rodjenja" value="{{ old('mesto_rodjenja', $selektor->mesto_rodjenja) }}">
                    @error('mesto_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_smrti" class="form-label">Datum smrti</label>
                    <input type="date" class="form-control @error('datum_smrti') is-invalid @enderror" 
                           id="datum_smrti" name="datum_smrti" 
                           value="{{ old('datum_smrti', $selektor->datum_smrti ? $selektor->datum_smrti->format('Y-m-d') : '') }}">
                    @error('datum_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_smrti" class="form-label">Mesto smrti</label>
                    <input type="text" class="form-control @error('mesto_smrti') is-invalid @enderror" 
                           id="mesto_smrti" name="mesto_smrti" value="{{ old('mesto_smrti', $selektor->mesto_smrti) }}">
                    @error('mesto_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="drzavljanstvo" class="form-label">Državljanstvo</label>
                <input type="text" class="form-control @error('drzavljanstvo') is-invalid @enderror" 
                       id="drzavljanstvo" name="drzavljanstvo" value="{{ old('drzavljanstvo', $selektor->drzavljanstvo) }}">
                @error('drzavljanstvo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="biografija" class="form-label">Biografija</label>
                <textarea class="form-control @error('biografija') is-invalid @enderror" 
                          id="biografija" name="biografija" rows="3">{{ old('biografija', $selektor->biografija) }}</textarea>
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
                
                @if($selektor->fotografija_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $selektor->fotografija_path) }}" alt="{{ $selektor->ime_prezime }}" class="img-thumbnail" style="max-height: 100px">
                        <p class="small text-muted">Trenutna fotografija. Otpremite novu da je zamenite.</p>
                    </div>
                @endif
            </div>
            
            <hr>
            
            <h4 class="mb-3">Mandati</h4>
            
            @if($selektor->mandati->count() > 0)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Mandati se mogu upravljati na stranici za pregled selektora.
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Ovaj selektor nema evidentirane mandate. Dodajte ih na stranici za pregled selektora.
                </div>
            @endif
            
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>

@if($selektor->mandati->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Pregled mandata</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tim</th>
                            <th>Period</th>
                            <th>Status</th>
                            <th>Napomena</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selektor->mandati->sortByDesc('pocetak_mandata') as $mandat)
                        <tr>
                            <td>{{ $mandat->tim->naziv }}</td>
                            <td>
                                {{ $mandat->pocetak_mandata->format('d.m.Y') }} - 
                                {{ $mandat->kraj_mandata ? $mandat->kraj_mandata->format('d.m.Y') : 'danas' }}
                            </td>
                            <td>
                                @if($mandat->v_d_status)
                                    <span class="badge bg-warning text-dark">v.d.</span>
                                @else
                                    <span class="badge bg-success">Stalni</span>
                                @endif
                            </td>
                            <td>{{ $mandat->napomena }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection