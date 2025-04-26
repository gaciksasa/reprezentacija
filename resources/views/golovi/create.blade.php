@extends('layouts.app')

@section('title', 'Dodaj gol')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novi gol</h1>
    <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4 text-md-end">
                <h1>{{ $utakmica->domacin->naziv }}</h1>
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
                <h1>{{ $utakmica->gost->naziv }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('golovi.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="utakmica_id" value="{{ $utakmica->id }}">
            
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
            
            <div class="mb-3">
                <label for="igrac_id" class="form-label">Igrač *</label>
                <select class="form-select @error('igrac_id') is-invalid @enderror" 
                        id="igrac_id" name="igrac_id" required>
                    <option value="">-- Izaberite igrača --</option>
                    <optgroup label="{{ $utakmica->domacin->naziv }}" data-team-id="{{ $utakmica->domacin_id }}">
                        @foreach($igraciDomacina as $igrac)
                            <option value="{{ $igrac->id }}" {{ old('igrac_id') == $igrac->id ? 'selected' : '' }}>
                                {{ $igrac->ime }} {{ $igrac->prezime }}
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="{{ $utakmica->gost->naziv }}" data-team-id="{{ $utakmica->gost_id }}">
                        @foreach($igraciGosta as $igrac)
                            <option value="{{ $igrac->id }}" {{ old('igrac_id') == $igrac->id ? 'selected' : '' }}>
                                {{ $igrac->ime }} {{ $igrac->prezime }}
                            </option>
                        @endforeach
                    </optgroup>
                </select>
                @error('igrac_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="minut" class="form-label">Minut</label>
                <input type="number" class="form-control @error('minut') is-invalid @enderror" 
                       id="minut" name="minut" value="{{ old('minut') }}" min="1" max="120">
                @error('minut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="penal" name="penal" {{ old('penal') ? 'checked' : '' }}>
                <label class="form-check-label" for="penal">Gol iz penala</label>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="auto_gol" name="auto_gol" {{ old('auto_gol') ? 'checked' : '' }}>
                <label class="form-check-label" for="auto_gol">Autogol</label>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj gol</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Funkcija za filtriranje igrača na osnovu izabranog tima
    function filterPlayersByTeam() {
        const timId = document.getElementById('tim_id').value;
        const igracSelect = document.getElementById('igrac_id');
        
        // Ako tim nije izabran, sakrijemo sve opcije
        if (!timId) {
            for (const optgroup of igracSelect.querySelectorAll('optgroup')) {
                optgroup.style.display = 'none';
            }
            return;
        }
        
        // Prikažemo samo optgroupu tima koji je izabran
        for (const optgroup of igracSelect.querySelectorAll('optgroup')) {
            if (optgroup.getAttribute('data-team-id') === timId) {
                optgroup.style.display = '';
            } else {
                optgroup.style.display = 'none';
            }
        }
        
        // Resetujemo izabranog igrača
        igracSelect.value = '';
    }
    
    // Pozivamo funkciju inicijalno
    document.addEventListener('DOMContentLoaded', function() {
        filterPlayersByTeam();
        
        // Dodajemo event listener za promenu tima
        document.getElementById('tim_id').addEventListener('change', filterPlayersByTeam);
    });
</script>
@endsection