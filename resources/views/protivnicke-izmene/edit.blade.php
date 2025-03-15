@extends('layouts.app')

@section('title', 'Izmeni protivničku izmenu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni protivničku izmenu</h1>
    <a href="{{ route('utakmice.show', $izmena->utakmica) }}" class="btn btn-secondary">
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
                <h5>{{ $izmena->utakmica->domacin->naziv }}</h5>
            </div>
            <div class="col-md-4 text-center">
                <div class="display-5">{{ $izmena->utakmica->rezultat_domacin }} - {{ $izmena->utakmica->rezultat_gost }}</div>
                <div class="text-muted">{{ $izmena->utakmica->datum->format('d.m.Y') }}</div>
                <div>
                    @if($izmena->utakmica->takmicenje)
                        {{ $izmena->utakmica->takmicenje->naziv }}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <h5>{{ $izmena->utakmica->gost->naziv }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Izmeni protivničku izmenu za tim: {{ $izmena->tim->naziv }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('protivnicke-izmene/'.$izmena->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="igrac_out_id" class="form-label">Igrač koji izlazi *</label>
                <select class="form-select @error('igrac_out_id') is-invalid @enderror" 
                        id="igrac_out_id" name="igrac_out_id" required>
                    <option value="">-- Izaberite igrača --</option>
                    @foreach($igraci as $igrac)
                        <option value="{{ $igrac->id }}" {{ old('igrac_out_id', $izmena->igrac_out_id) == $igrac->id ? 'selected' : '' }}>
                            {{ $igrac->prezime }} {{ $igrac->ime }}
                        </option>
                    @endforeach
                </select>
                @error('igrac_out_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="igrac_in_id" class="form-label">Igrač koji ulazi *</label>
                <select class="form-select @error('igrac_in_id') is-invalid @enderror" 
                        id="igrac_in_id" name="igrac_in_id" required>
                    <option value="">-- Izaberite igrača --</option>
                    @foreach($igraci as $igrac)
                        <option value="{{ $igrac->id }}" {{ old('igrac_in_id', $izmena->igrac_in_id) == $igrac->id ? 'selected' : '' }}>
                            {{ $igrac->prezime }} {{ $igrac->ime }}
                        </option>
                    @endforeach
                </select>
                @error('igrac_in_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="minut" class="form-label">Minut *</label>
                <input type="number" class="form-control @error('minut') is-invalid @enderror" 
                       id="minut" name="minut" value="{{ old('minut', $izmena->minut) }}" required min="1" max="120">
                @error('minut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="napomena" class="form-label">Napomena</label>
                <textarea class="form-control @error('napomena') is-invalid @enderror" 
                          id="napomena" name="napomena" rows="2">{{ old('napomena', $izmena->napomena) }}</textarea>
                @error('napomena')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>
@endsection