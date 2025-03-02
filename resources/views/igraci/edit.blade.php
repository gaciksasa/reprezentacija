@extends('layouts.app')

@section('title', 'Izmeni igrača')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni igrača: {{ $igrac->ime }} {{ $igrac->prezime }}</h1>
    <a href="{{ route('igraci.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('igraci.update', $igrac) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ime" class="form-label">Ime *</label>
                    <input type="text" class="form-control @error('ime') is-invalid @enderror" 
                           id="ime" name="ime" value="{{ old('ime', $igrac->ime) }}" required>
                    @error('ime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="prezime" class="form-label">Prezime *</label>
                    <input type="text" class="form-control @error('prezime') is-invalid @enderror" 
                           id="prezime" name="prezime" value="{{ old('prezime', $igrac->prezime) }}" required>
                    @error('prezime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pozicija" class="form-label">Pozicija *</label>
                    <select class="form-select @error('pozicija') is-invalid @enderror" 
                        id="pozicija" name="pozicija" required>
                        <option value="">-- Izaberite poziciju --</option>
                        @foreach($pozicije as $pozicija)
                            <option value="{{ $pozicija }}" {{ old('pozicija', $igrac->pozicija) == $pozicija ? 'selected' : '' }}>
                                {{ $pozicija }}
                            </option>
                        @endforeach
                    </select>
                    @error('pozicija')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="fotografija" class="form-label">Fotografija</label>
                    <input type="file" class="form-control @error('fotografija') is-invalid @enderror" 
                           id="fotografija" name="fotografija">
                    @error('fotografija')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    @if($igrac->fotografija_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $igrac->fotografija_path) }}" alt="{{ $igrac->ime }} {{ $igrac->prezime }}" class="img-thumbnail" style="max-height: 100px">
                            <p class="small text-muted">Trenutna fotografija. Otpremite novu da zamenite.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <h4 class="mt-4 mb-3">Lični podaci</h4>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_rodjenja" class="form-label">Datum rođenja</label>
                    <input type="date" class="form-control @error('datum_rodjenja') is-invalid @enderror" 
                        id="datum_rodjenja" name="datum_rodjenja" value="{{ old('datum_rodjenja', $igrac->datum_rodjenja ? $igrac->datum_rodjenja->format('Y-m-d') : '') }}">
                    @error('datum_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_rodjenja" class="form-label">Mesto rođenja</label>
                    <input type="text" class="form-control @error('mesto_rodjenja') is-invalid @enderror" 
                        id="mesto_rodjenja" name="mesto_rodjenja" value="{{ old('mesto_rodjenja', $igrac->mesto_rodjenja) }}">
                    @error('mesto_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_smrti" class="form-label">Datum smrti</label>
                    <input type="date" class="form-control @error('datum_smrti') is-invalid @enderror" 
                        id="datum_smrti" name="datum_smrti" value="{{ old('datum_smrti', $igrac->datum_smrti ? $igrac->datum_smrti->format('Y-m-d') : '') }}">
                    @error('datum_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_smrti" class="form-label">Mesto smrti</label>
                    <input type="text" class="form-control @error('mesto_smrti') is-invalid @enderror" 
                        id="mesto_smrti" name="mesto_smrti" value="{{ old('mesto_smrti', $igrac->mesto_smrti) }}">
                    @error('mesto_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="biografija" class="form-label">Biografija</label>
                <textarea class="form-control @error('biografija') is-invalid @enderror" 
                          id="biografija" name="biografija" rows="4">{{ old('biografija', $igrac->biografija) }}</textarea>
                @error('biografija')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <hr>
            <h4 class="mb-3">Bivši klubovi</h4>
            
            <div id="bivsi-klubovi-container">
                @if($igrac->bivsiKlubovi->count() > 0)
                    @foreach($igrac->bivsiKlubovi as $index => $klub)
                        <div class="bivsi-klub-row mb-4">
                            <input type="hidden" name="bivsi_klubovi[{{ $index }}][id]" value="{{ $klub->id }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Naziv kluba *</label>
                                    <input type="text" class="form-control" name="bivsi_klubovi[{{ $index }}][naziv]" value="{{ $klub->naziv }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Država kluba</label>
                                    <input type="text" class="form-control" name="bivsi_klubovi[{{ $index }}][drzava]" value="{{ $klub->drzava }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stepen takmičenja</label>
                                    <input type="text" class="form-control" name="bivsi_klubovi[{{ $index }}][stepen_takmicenja]" value="{{ $klub->stepen_takmicenja }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Broj nastupa</label>
                                    <input type="number" class="form-control" name="bivsi_klubovi[{{ $index }}][broj_nastupa]" value="{{ $klub->broj_nastupa }}" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Broj golova</label>
                                    <input type="number" class="form-control" name="bivsi_klubovi[{{ $index }}][broj_golova]" value="{{ $klub->broj_golova }}" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Period od</label>
                                    <input type="date" class="form-control" name="bivsi_klubovi[{{ $index }}][period_od]" value="{{ $klub->period_od ? $klub->period_od->format('Y-m-d') : '' }}">
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Period do</label>
                                    <input type="date" class="form-control" name="bivsi_klubovi[{{ $index }}][period_do]" value="{{ $klub->period_do ? $klub->period_do->format('Y-m-d') : '' }}">
                                </div>
                                <div class="col-md-2 mb-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-klub-btn">Ukloni</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bivsi-klub-row mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Naziv kluba *</label>
                                <input type="text" class="form-control" name="bivsi_klubovi[0][naziv]" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Država kluba</label>
                                <input type="text" class="form-control" name="bivsi_klubovi[0][drzava]">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stepen takmičenja</label>
                                <input type="text" class="form-control" name="bivsi_klubovi[0][stepen_takmicenja]">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Broj nastupa</label>
                                <input type="number" class="form-control" name="bivsi_klubovi[0][broj_nastupa]" min="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Broj golova</label>
                                <input type="number" class="form-control" name="bivsi_klubovi[0][broj_golova]" min="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Period od</label>
                                <input type="date" class="form-control" name="bivsi_klubovi[0][period_od]">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Period do</label>
                                <input type="date" class="form-control" name="bivsi_klubovi[0][period_do]">
                            </div>
                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-klub-btn">Ukloni</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="add-klub-btn">
                    <i class="fas fa-plus"></i> Dodaj bivši klub
                </button>
            </div>
            
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('bivsi-klubovi-container');
        const addButton = document.getElementById('add-klub-btn');
        let klubCounter = {{ $igrac->bivsiKlubovi->count() > 0 ? $igrac->bivsiKlubovi->count() : 1 }};
        
        // Add new club row
        addButton.addEventListener('click', function() {
            const newRow = document.querySelector('.bivsi-klub-row').cloneNode(true);
            
            // Update all input names with new index
            const inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, `[${klubCounter}]`);
                    input.setAttribute('name', newName);
                    input.value = ''; // Clear values
                }
            });
            
            // Remove any hidden id field for existing records
            const hiddenIdField = newRow.querySelector('input[name^="bivsi_klubovi"][name$="[id]"]');
            if (hiddenIdField) {
                hiddenIdField.remove();
            }
            
            // Configure remove button
            const removeBtn = newRow.querySelector('.remove-klub-btn');
            removeBtn.style.display = 'block';
            
            container.appendChild(newRow);
            klubCounter++;
        });
        
        // Set up event delegation for remove buttons
        container.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-klub-btn')) {
                const row = e.target.closest('.bivsi-klub-row');
                
                // Check if this is the only row
                if (container.querySelectorAll('.bivsi-klub-row').length > 1) {
                    row.remove();
                } else {
                    // If it's the last row, just clear the values instead of removing
                    const inputs = row.querySelectorAll('input:not([type="hidden"])');
                    inputs.forEach(input => {
                        input.value = '';
                    });
                }
            }
        });
        
        // If there's only one row initially (either empty or with data), hide its remove button
        if (container.querySelectorAll('.bivsi-klub-row').length === 1) {
            const firstRemoveBtn = container.querySelector('.bivsi-klub-row .remove-klub-btn');
            if (firstRemoveBtn) {
                firstRemoveBtn.style.display = 'none';
            }
        }
    });
</script>
@endsection