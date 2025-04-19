@extends('layouts.app')

@section('title', 'Izmeni selektorsku komisiju')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni selektorsku komisiju</h1>
    <a href="{{ route('selektori.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('selektor-komisija.update', $mandat->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="tim_id" class="form-label">Tim *</label>
                <select class="form-select @error('tim_id') is-invalid @enderror" 
                        id="tim_id" name="tim_id" required>
                    <option value="">-- Izaberite tim --</option>
                    @foreach($timovi as $tim)
                        <option value="{{ $tim->id }}" {{ old('tim_id', $mandat->tim_id) == $tim->id ? 'selected' : '' }}>
                            {{ $tim->naziv }}
                        </option>
                    @endforeach
                </select>
                @error('tim_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pocetak_mandata" class="form-label">Početak mandata *</label>
                    <input type="date" class="form-control @error('pocetak_mandata') is-invalid @enderror"
                           id="pocetak_mandata" name="pocetak_mandata" 
                           value="{{ old('pocetak_mandata', $mandat->pocetak_mandata->format('Y-m-d')) }}" required>
                    @error('pocetak_mandata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="kraj_mandata" class="form-label">Kraj mandata</label>
                    <input type="date" class="form-control @error('kraj_mandata') is-invalid @enderror"
                           id="kraj_mandata" name="kraj_mandata" 
                           value="{{ old('kraj_mandata', $mandat->kraj_mandata ? $mandat->kraj_mandata->format('Y-m-d') : '') }}">
                    <small class="form-text text-muted">Ostavite prazno ako je komisija trenutno aktivna</small>
                    @error('kraj_mandata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <label for="glavni_selektor_id" class="form-label">Glavni selektor komisije *</label>
                <select class="form-select @error('glavni_selektor_id') is-invalid @enderror"
                        id="glavni_selektor_id" name="glavni_selektor_id" required>
                    <option value="">-- Izaberite glavnog selektora --</option>
                    @foreach($selektori as $selektor)
                        <option value="{{ $selektor->id }}" {{ old('glavni_selektor_id', $glavniSelektor->id) == $selektor->id ? 'selected' : '' }}>
                            {{ $selektor->prezime }} {{ $selektor->ime }}
                        </option>
                    @endforeach
                </select>
                @error('glavni_selektor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="form-label">Ostali članovi komisije *</label>
                <div class="card">
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        @foreach($selektori as $selektor)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    id="clan-{{ $selektor->id }}" name="clanovi_komisije[]" 
                                    value="{{ $selektor->id }}" 
                                    {{ in_array($selektor->id, old('clanovi_komisije', array_merge([$glavniSelektor->id], $ostaliClanovi))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="clan-{{ $selektor->id }}">
                                    {{ $selektor->prezime }} {{ $selektor->ime }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('clanovi_komisije')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="napomena" class="form-label">Napomena</label>
                <textarea class="form-control @error('napomena') is-invalid @enderror"
                        id="napomena" name="napomena" rows="3">{{ old('napomena', $mandat->napomena) }}</textarea>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Automatski odaberi glavnog selektora u listi članova komisije
        const glavniSelektor = document.getElementById('glavni_selektor_id');
        glavniSelektor.addEventListener('change', function() {
            const selektorId = this.value;
            if (selektorId) {
                const checkboxId = 'clan-' + selektorId;
                const checkbox = document.getElementById(checkboxId);
                if (checkbox) {
                    checkbox.checked = true;
                }
            }
        });
        
        // Configure date inputs to use dd.mm.yyyy format
        const dateInputs = document.querySelectorAll('input[type="date"]');
        
        dateInputs.forEach(function(input) {
            // Create a text input to replace the date input
            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.name = input.name;
            textInput.id = input.id;
            textInput.className = input.className;
            textInput.placeholder = 'dd.mm.yyyy';
            textInput.required = input.required;
            
            // Copy any existing value, converting from yyyy-mm-dd to dd.mm.yyyy
            if (input.value) {
                const dateParts = input.value.split('-');
                if (dateParts.length === 3) {
                    textInput.value = `${dateParts[2]}.${dateParts[1]}.${dateParts[0]}`;
                }
            }
            
            // Add event listener to format input and convert back to yyyy-mm-dd for form submission
            textInput.addEventListener('blur', function() {
                const value = this.value;
                if (value) {
                    // Check if the input matches the dd.mm.yyyy format
                    const dateRegex = /^(\d{1,2})\.(\d{1,2})\.(\d{4})$/;
                    const match = value.match(dateRegex);
                    
                    if (match) {
                        const day = match[1].padStart(2, '0');
                        const month = match[2].padStart(2, '0');
                        const year = match[3];
                        
                        // Format for display
                        this.value = `${day}.${month}.${year}`;
                        
                        // Create hidden input for form submission in yyyy-mm-dd format
                        let hiddenInput = document.getElementById(`${this.id}_hidden`);
                        if (!hiddenInput) {
                            hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = this.name;
                            hiddenInput.id = `${this.id}_hidden`;
                            this.parentNode.appendChild(hiddenInput);
                            
                            // Change the name of the text input so it doesn't conflict
                            this.name = `${this.name}_display`;
                        }
                        
                        hiddenInput.value = `${year}-${month}-${day}`;
                    }
                }
            });
            
            // Replace the date input with the text input
            input.parentNode.replaceChild(textInput, input);
        });
    });
</script>
@endsection